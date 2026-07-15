import Lenis from 'lenis';

document.documentElement.classList.add('js');

const legendAssistant = document.querySelector('[data-legend-assistant]');

if (legendAssistant) {
  const panel = legendAssistant.querySelector('[data-legend-panel]');
  const launcher = legendAssistant.querySelector('[data-legend-launcher]');
  const closeButton = legendAssistant.querySelector('[data-legend-close]');
  const input = legendAssistant.querySelector('[data-legend-input]');
  const sendButton = legendAssistant.querySelector('[data-legend-send]');
  const messages = legendAssistant.querySelector('[data-legend-messages]');
  const consentGate = legendAssistant.querySelector('[data-legend-consent]');
  const consentContinue = legendAssistant.querySelector('[data-legend-consent-continue]');
  const consentDecline = legendAssistant.querySelector('[data-legend-consent-decline]');
  const composer = legendAssistant.querySelector('[data-legend-composer]');
  const notice = legendAssistant.querySelector('[data-legend-notice]');
  const clearChatButton = legendAssistant.querySelector('[data-legend-clear]');
  const endpoint = legendAssistant.dataset.legendEndpoint || '';
  const nonce = legendAssistant.dataset.legendNonce || '';
  const sprites = Array.from(legendAssistant.querySelectorAll('[data-legend-sprite]'));
  const launcherCharacter = legendAssistant.querySelector('[data-legend-character]');
  const roamer = legendAssistant.querySelector('[data-legend-roamer]');
  const roamerSprite = legendAssistant.querySelector('[data-legend-roamer-sprite]');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  let replyTimer = 0;
  let spriteTimer = 0;
  let roamerSpriteTimer = 0;
  let roamerMotionTimer = 0;
  let roamerIsRight = false;
  let isOpen = false;
  let isTransitioning = false;
  let chatAcknowledged = false;
  const conversation = [];
  const welcomeMessage = messages.firstElementChild?.cloneNode(true);
  const chatStorageKey = 'fenster_legend_chat_v1';
  const chatStorageLifetime = 24 * 60 * 60 * 1000;

  const spriteSequences = {
    idle: { row: 0, frames: [0, 1, 2, 3, 4, 5], timings: [900, 180, 180, 260, 260, 1400], loop: true },
    runningRight: { row: 1, frames: [0, 1, 2, 3, 4, 5, 6, 7], timings: [120, 120, 120, 120, 120, 120, 120, 220], loop: true },
    runningLeft: { row: 2, frames: [0, 1, 2, 3, 4, 5, 6, 7], timings: [120, 120, 120, 120, 120, 120, 120, 220], loop: true },
    jumping: { row: 4, frames: [0, 1, 2, 3, 4], timings: [240, 260, 300, 300, 340], loop: false },
  };

  const showSpriteFrame = (row, column) => {
    sprites.forEach((sprite) => {
      sprite.style.setProperty('--legend-row', row);
      sprite.style.setProperty('--legend-column', column);
    });
  };

  const playSprite = (name = 'idle') => {
    window.clearTimeout(spriteTimer);
    const sequence = spriteSequences[name] || spriteSequences.idle;
    let index = 0;

    if (reduceMotion.matches) {
      showSpriteFrame(sequence.row, sequence.frames[0]);
      return;
    }

    const advance = () => {
      showSpriteFrame(sequence.row, sequence.frames[index]);
      const delay = sequence.timings[index] || 160;
      index += 1;

      if (index >= sequence.frames.length) {
        if (!sequence.loop) {
          spriteTimer = window.setTimeout(() => playSprite('idle'), delay);
          return;
        }
        index = 0;
      }

      spriteTimer = window.setTimeout(advance, delay);
    };

    advance();
  };

  const showRoamerFrame = (row, column) => {
    roamerSprite?.style.setProperty('--legend-row', row);
    roamerSprite?.style.setProperty('--legend-column', column);
  };

  const playRoamerSprite = (name = 'idle') => {
    window.clearTimeout(roamerSpriteTimer);
    const sequence = spriteSequences[name] || spriteSequences.idle;
    let index = 0;

    if (reduceMotion.matches) {
      showRoamerFrame(sequence.row, sequence.frames[0]);
      return;
    }

    const advance = () => {
      showRoamerFrame(sequence.row, sequence.frames[index]);
      const delay = sequence.timings[index] || 160;
      index = (index + 1) % sequence.frames.length;
      roamerSpriteTimer = window.setTimeout(advance, delay);
    };

    advance();
  };

  const stopRoaming = () => {
    window.clearTimeout(roamerMotionTimer);
    window.clearTimeout(roamerSpriteTimer);
  };

  const travelLegend = async (source, target, direction = 'up') => {
    if (!source || !target || reduceMotion.matches) return;

    const sourceRect = source.getBoundingClientRect();
    const targetRect = target.getBoundingClientRect();
    if (!sourceRect.width || !targetRect.width) return;

    let targetLeft = targetRect.left;
    let targetTop = targetRect.top;

    // The drawer is still translating in when the jump begins. Measure Legend's
    // destination against the drawer's settled right-edge position so he does
    // not chase the temporary off-screen transform and teleport back afterwards.
    if (panel.contains(target)) {
      const panelRect = panel.getBoundingClientRect();
      const settledPanelLeft = document.documentElement.clientWidth - panelRect.width;
      targetLeft -= panelRect.left - settledPanelLeft;
    }

    const traveller = document.createElement('span');
    const sourceSprite = source.querySelector('.legend-sprite');
    const travellerSprite = sourceSprite?.cloneNode(true);
    if (!travellerSprite) return;

    traveller.className = 'legend-assistant__traveller';
    traveller.setAttribute('aria-hidden', 'true');
    traveller.style.left = `${sourceRect.left}px`;
    traveller.style.top = `${sourceRect.top}px`;
    traveller.style.width = `${sourceRect.width}px`;
    traveller.style.height = `${sourceRect.height}px`;
    traveller.append(travellerSprite);
    document.body.append(traveller);

    const sequence = spriteSequences.jumping;
    let frameIndex = 0;
    let frameTimer = 0;
    const advanceFrame = () => {
      travellerSprite.style.setProperty('--legend-row', sequence.row);
      travellerSprite.style.setProperty('--legend-column', sequence.frames[frameIndex]);
      const delay = sequence.timings[frameIndex] || 280;
      if (frameIndex < sequence.frames.length - 1) {
        frameIndex += 1;
        frameTimer = window.setTimeout(advanceFrame, delay);
      }
    };
    advanceFrame();

    if (typeof traveller.animate !== 'function') {
      window.clearTimeout(frameTimer);
      traveller.remove();
      return;
    }

    const distanceX = targetLeft - sourceRect.left;
    const distanceY = targetTop - sourceRect.top;
    const targetScale = targetRect.width / sourceRect.width;
    const lift = direction === 'up' ? 84 : 58;
    const duration = 1440;
    const motion = traveller.animate([
      { transform: 'translate3d(0, 0, 0) scale(1)', offset: 0 },
      {
        transform: `translate3d(${distanceX * 0.14}px, ${(distanceY * 0.12) - (lift * 0.55)}px, 0) scale(${1 + ((targetScale - 1) * 0.14)})`,
        offset: 0.18,
      },
      {
        transform: `translate3d(${distanceX * 0.56}px, ${(distanceY * 0.5) - lift}px, 0) scale(${1 + ((targetScale - 1) * 0.56)})`,
        offset: 0.56,
      },
      {
        transform: `translate3d(${distanceX * 0.86}px, ${(distanceY * 0.84) - (lift * 0.36)}px, 0) scale(${1 + ((targetScale - 1) * 0.86)})`,
        offset: 0.84,
      },
      {
        transform: `translate3d(${distanceX}px, ${distanceY}px, 0) scale(${targetScale})`,
        offset: 1,
      },
    ], {
      duration,
      easing: 'cubic-bezier(0.34, 0.72, 0.32, 1)',
      fill: 'forwards',
    });

    try {
      await motion.finished;
    } catch (error) {
      // A resize or navigation can cancel the visual handoff safely.
    }

    window.clearTimeout(frameTimer);
    traveller.remove();
  };

  const startRoaming = () => {
    stopRoaming();

    if (!roamer || !roamerSprite || reduceMotion.matches) {
      showRoamerFrame(spriteSequences.idle.row, spriteSequences.idle.frames[0]);
      return;
    }

    const scheduleNextRun = () => {
      const pause = roamerIsRight ? 2800 : 3400;
      playRoamerSprite('idle');
      roamerMotionTimer = window.setTimeout(() => {
        const movingRight = !roamerIsRight;
        playRoamerSprite(movingRight ? 'runningRight' : 'runningLeft');
        roamer.classList.toggle('is-at-right', movingRight);
        roamerMotionTimer = window.setTimeout(() => {
          roamerIsRight = movingRight;
          scheduleNextRun();
        }, 2200);
      }, pause);
    };

    scheduleNextRun();
  };

  const syncCookieOffset = () => {
    const banner = document.querySelector('[data-fg-cookie-consent]');
    const settings = document.querySelector('[data-fg-cookie-settings]');
    let offset = 0;

    if (banner && !banner.hidden) {
      offset = Math.ceil(banner.getBoundingClientRect().height + 16);
    } else if (settings && !settings.hidden) {
      offset = Math.ceil(settings.getBoundingClientRect().height + 16);
    }

    legendAssistant.style.setProperty('--legend-cookie-offset', `${offset}px`);
  };

  const observeCookieControls = () => {
    const controls = document.querySelectorAll('[data-fg-cookie-consent], [data-fg-cookie-settings]');
    const observer = new MutationObserver(syncCookieOffset);
    controls.forEach((control) => observer.observe(control, { attributes: true, attributeFilter: ['hidden'] }));
    syncCookieOffset();
  };

  const resizeInput = () => {
    input.style.height = 'auto';
    input.style.height = `${Math.min(input.scrollHeight, 112)}px`;
  };

  const scrollToLatestMessage = () => {
    messages.scrollTop = messages.scrollHeight;
  };

  const appendLegendFormatting = (element, text) => {
    const parts = text.split(/(\*\*[^*\n]+\*\*)/g);

    parts.forEach((part) => {
      if (part.startsWith('**') && part.endsWith('**') && part.length > 4) {
        const strong = document.createElement('strong');
        strong.textContent = part.slice(2, -2);
        element.append(strong);
        return;
      }

      element.append(document.createTextNode(part));
    });
  };

  const addMessage = (text, role) => {
    const message = document.createElement('div');
    const author = document.createElement('span');
    const copy = document.createElement('p');
    message.className = `legend-message legend-message--${role}`;
    author.className = 'legend-message__author';
    author.textContent = role === 'assistant' ? 'Legend' : 'You';
    if (role === 'assistant') {
      appendLegendFormatting(copy, text);
    } else {
      copy.textContent = text;
    }
    message.append(author, copy);
    messages.append(message);
    scrollToLatestMessage();
  };

  const setChatAcknowledged = (acknowledged) => {
    chatAcknowledged = acknowledged;
    legendAssistant.classList.toggle('is-chat-acknowledged', acknowledged);
    consentGate.hidden = acknowledged;
    composer.hidden = !acknowledged;
    notice.hidden = !acknowledged;
  };

  const storedConversation = (value) => {
    if (!Array.isArray(value)) return [];

    return value
      .filter((item) => item && ['user', 'assistant'].includes(item.role) && typeof item.content === 'string')
      .slice(-16)
      .map((item) => ({
        role: item.role,
        content: item.content.trim().slice(0, 900),
      }))
      .filter((item) => item.content);
  };

  const readLegendState = () => {
    try {
      const state = JSON.parse(window.localStorage.getItem(chatStorageKey) || 'null');
      const updatedAt = Number(state?.updatedAt || 0);

      if (!state || state.version !== 1 || !state.acknowledged || Date.now() - updatedAt > chatStorageLifetime) {
        if (state) window.localStorage.removeItem(chatStorageKey);
        return null;
      }

      return {
        acknowledged: true,
        conversation: storedConversation(state.conversation),
      };
    } catch (error) {
      return null;
    }
  };

  const persistLegendState = () => {
    if (!chatAcknowledged) return;

    try {
      window.localStorage.setItem(chatStorageKey, JSON.stringify({
        version: 1,
        acknowledged: true,
        updatedAt: Date.now(),
        conversation: storedConversation(conversation),
      }));
    } catch (error) {
      // The chat still works for this page when browser storage is unavailable.
    }
  };

  const renderConversation = () => {
    if (welcomeMessage) {
      messages.replaceChildren(welcomeMessage.cloneNode(true));
    } else {
      messages.replaceChildren();
    }

    conversation.forEach((item) => addMessage(item.content, item.role));
  };

  const restoreLegendState = () => {
    const state = readLegendState();
    if (!state) return;

    conversation.splice(0, conversation.length, ...state.conversation);
    renderConversation();
    setChatAcknowledged(true);
  };

  const clearLegendChat = () => {
    if (replyTimer) return;
    conversation.splice(0, conversation.length);
    renderConversation();
    persistLegendState();
    input.value = '';
    resizeInput();
    sendButton.disabled = true;
    input.focus();
  };

  const addTypingIndicator = () => {
    const indicator = document.createElement('div');
    indicator.className = 'legend-message legend-message--assistant legend-message--typing';
    indicator.dataset.legendTyping = '';
    indicator.innerHTML = '<span class="screen-reader-text">Legend is typing</span><i></i><i></i><i></i>';
    messages.append(indicator);
    scrollToLatestMessage();
  };

  const normalisePageText = (value) => value
    .replace(/\r/g, '')
    .replace(/[ \t]+/g, ' ')
    .replace(/\n{3,}/g, '\n\n')
    .trim();

  const collectHighPriorityFacts = () => {
    const facts = [];
    const seen = new Set();
    const candidates = document.querySelectorAll([
      'main .fg-product-pulse--usps',
      'main [aria-label*="specification" i]',
      'main [aria-label*="technical" i]',
      'main .fg-product-intel__summary',
      'main .fg-sash-spec-table',
    ].join(','));

    candidates.forEach((element) => {
      const label = element.getAttribute('aria-label') || '';
      const copy = normalisePageText(`${label}\n${element.textContent || ''}`).slice(0, 1600);
      const key = copy.toLowerCase();
      if (!copy || seen.has(key)) return;
      seen.add(key);
      facts.push(copy);
    });

    return facts.slice(0, 12).join('\n\n').slice(0, 8000);
  };

  const collectPageContext = () => {
    const description = document.querySelector('meta[name="description"]')?.content || '';
    const headerText = document.querySelector('.site-header')?.textContent || '';
    const mainText = document.querySelector('main')?.textContent || '';
    const footerText = document.querySelector('.site-footer')?.textContent || '';
    const pageUrl = new URL(window.location.href);
    pageUrl.username = '';
    pageUrl.password = '';
    pageUrl.search = '';
    pageUrl.hash = '';

    return {
      page_title: document.title.slice(0, 180),
      page_url: pageUrl.href.slice(0, 1000),
      page_description: description.slice(0, 320),
      page_facts: collectHighPriorityFacts(),
      page_text: normalisePageText(`${headerText}\n\n${mainText}\n\n${footerText}`).slice(0, 60000),
    };
  };

  const requestLegendReply = async (message) => {
    const controller = new AbortController();
    const timeout = window.setTimeout(() => controller.abort(), 45000);

    try {
      const response = await fetch(endpoint, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'X-Fenster-Legend-Nonce': nonce,
        },
        body: JSON.stringify({
          message,
          conversation: conversation.slice(-8),
          ...collectPageContext(),
        }),
        signal: controller.signal,
      });
      const payload = await response.json().catch(() => ({}));

      if (!response.ok || typeof payload.reply !== 'string' || !payload.reply.trim()) {
        const error = new Error(payload.message || 'Legend could not answer just now.');
        error.code = payload.code || 'request_failed';
        throw error;
      }

      return payload.reply.trim();
    } finally {
      window.clearTimeout(timeout);
    }
  };

  const openChat = async () => {
    if (isTransitioning || isOpen) return;

    isOpen = true;
    isTransitioning = true;
    document.documentElement.classList.add('legend-chat-open');
    panel.hidden = false;
    launcher.setAttribute('aria-expanded', 'true');
    stopRoaming();
    roamer?.classList.remove('is-at-right');
    roamerIsRight = false;
    showRoamerFrame(spriteSequences.jumping.row, spriteSequences.jumping.frames[0]);

    const travel = travelLegend(launcherCharacter, roamer, 'up');
    legendAssistant.classList.add('is-transitioning');
    await travel;

    legendAssistant.classList.add('is-open', 'has-arrived');
    legendAssistant.classList.remove('is-transitioning');
    isTransitioning = false;
    startRoaming();
    (chatAcknowledged ? input : consentContinue)?.focus();
  };

  const closeChat = async () => {
    if (isTransitioning || !isOpen) return;

    isTransitioning = true;
    isOpen = false;
    launcher.setAttribute('aria-expanded', 'false');
    stopRoaming();

    const travel = travelLegend(roamer, launcherCharacter, 'down');
    panel.classList.add('is-closing');
    legendAssistant.classList.add('is-transitioning');
    legendAssistant.classList.remove('is-open', 'has-arrived');
    await travel;
    panel.hidden = true;
    panel.classList.remove('is-closing');
    document.documentElement.classList.remove('legend-chat-open');

    roamer?.classList.remove('is-at-right');
    roamerIsRight = false;
    showRoamerFrame(spriteSequences.idle.row, spriteSequences.idle.frames[0]);
    legendAssistant.classList.remove('is-transitioning');
    isTransitioning = false;
    playSprite('idle');
    launcher.focus();
  };

  const sendMessage = async () => {
    const text = input.value.trim();
    if (!chatAcknowledged || !text || replyTimer) return;

    addMessage(text, 'user');
    conversation.push({ role: 'user', content: text });
    persistLegendState();
    input.value = '';
    resizeInput();
    sendButton.disabled = true;
    input.disabled = true;
    addTypingIndicator();
    replyTimer = 1;
    try {
      const reply = await requestLegendReply(text);
      messages.querySelector('[data-legend-typing]')?.remove();
      addMessage(reply, 'assistant');
      conversation.push({ role: 'assistant', content: reply });
      persistLegendState();
    } catch (error) {
      messages.querySelector('[data-legend-typing]')?.remove();
      let fallback = 'I’m having trouble connecting just now. Please try again shortly, or contact the Fenster team if you need help now.';
      if (error?.code === 'not_configured') {
        fallback = 'My AI connection hasn’t been switched on yet. Once the server key is added, I’ll be able to answer using this page.';
      } else if (error?.code === 'rate_limited') {
        fallback = 'I’ve received a lot of messages in a short time. Please wait a moment and try again. My AI connection is still online.';
      }
      addMessage(fallback, 'assistant');
    } finally {
      input.disabled = false;
      replyTimer = 0;
      playSprite('idle');
      input.focus();
    }
  };

  launcher.addEventListener('click', () => {
    if (isOpen) {
      closeChat();
    } else {
      openChat();
    }
  });
  closeButton.addEventListener('click', closeChat);
  consentContinue?.addEventListener('click', () => {
    setChatAcknowledged(true);
    persistLegendState();
    input.focus();
  });
  consentDecline?.addEventListener('click', closeChat);
  clearChatButton?.addEventListener('click', clearLegendChat);
  sendButton.addEventListener('click', sendMessage);
  input.addEventListener('input', () => {
    sendButton.disabled = !input.value.trim() || Boolean(replyTimer);
    resizeInput();
  });
  input.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && !event.shiftKey) {
      event.preventDefault();
      sendMessage();
    }
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && isOpen) closeChat();
  });
  window.addEventListener('resize', syncCookieOffset);
  window.addEventListener('load', syncCookieOffset, { once: true });
  window.addEventListener('storage', (event) => {
    if (event.key !== chatStorageKey || replyTimer) return;
    const state = readLegendState();
    if (!state) return;
    conversation.splice(0, conversation.length, ...state.conversation);
    renderConversation();
    setChatAcknowledged(true);
  });

  restoreLegendState();
  playSprite('idle');
  showRoamerFrame(spriteSequences.idle.row, spriteSequences.idle.frames[0]);
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', observeCookieControls, { once: true });
  } else {
    observeCookieControls();
  }
}

const clamp = (value, min = 0, max = 1) => Math.min(max, Math.max(min, value));

const integralBlindsReveal = document.querySelector('[data-fg-integral-blinds-reveal]');

if (
  integralBlindsReveal
  && window.matchMedia('(min-width: 861px)').matches
  && !window.matchMedia('(prefers-reduced-motion: reduce)').matches
) {
  const canvas = integralBlindsReveal.querySelector('[data-fg-integral-blinds-canvas]');
  const video = integralBlindsReveal.querySelector('[data-fg-integral-blinds-video]');
  const outputContext = canvas?.getContext('2d', { alpha: true });
  const keyCanvas = document.createElement('canvas');
  const keyContext = keyCanvas.getContext('2d', { alpha: true, willReadFrequently: true });
  let targetTime = 0;
  let seeking = false;
  let ready = false;
  let revealTarget = window.scrollY > 2 ? 1 : 0;
  let revealProgress = revealTarget;
  let revealComplete = revealTarget >= 1;
  let touchY = null;
  let revealAnimationFrame = 0;

  if (!revealComplete) {
    document.documentElement.classList.add('fg-blinds-reveal-locked');
    window.scrollTo(0, 0);
  }

  const smoothstep = (start, end, value) => {
    const amount = clamp((value - start) / Math.max(0.001, end - start));
    return amount * amount * (3 - 2 * amount);
  };

  const keyFrame = () => {
    if (!video || !canvas || !outputContext || !keyContext || video.readyState < 2) return;

    const sourceWidth = video.videoWidth || 960;
    const sourceHeight = video.videoHeight || 540;
    const width = Math.min(720, sourceWidth);
    const height = Math.round(width * (sourceHeight / sourceWidth));

    if (keyCanvas.width !== width || keyCanvas.height !== height) {
      keyCanvas.width = width;
      keyCanvas.height = height;
      canvas.width = width;
      canvas.height = height;
    }

    keyContext.clearRect(0, 0, width, height);
    keyContext.drawImage(video, 0, 0, sourceWidth, sourceHeight, 0, 0, width, height);

    const frame = keyContext.getImageData(0, 0, width, height);
    const pixels = frame.data;

    for (let index = 0; index < pixels.length; index += 4) {
      const red = pixels[index];
      const green = pixels[index + 1];
      const blue = pixels[index + 2];
      const colourDistance = Math.hypot(red - 117, green - 249, blue - 77);
      const greenLead = green - Math.max(red, blue);
      const colourMatch = 1 - smoothstep(42, 142, colourDistance);
      const greenMatch = smoothstep(34, 104, greenLead);
      const keyStrength = Math.max(colourMatch, greenMatch * smoothstep(105, 205, green));

      if (keyStrength > 0) {
        pixels[index + 3] = Math.round(255 * (1 - keyStrength));
        pixels[index + 1] = Math.round(green * (1 - keyStrength * 0.75));
      }
    }

    outputContext.clearRect(0, 0, width, height);
    outputContext.putImageData(frame, 0, 0);

    if (!ready) {
      ready = true;
      integralBlindsReveal.classList.add('is-ready');
    }
  };

  const requestFrame = () => {
    if (!video || seeking || video.readyState < 1) return;
    const difference = Math.abs(video.currentTime - targetTime);

    if (difference < 0.025) {
      keyFrame();
      return;
    }

    seeking = true;
    video.currentTime = targetTime;
  };

  const updateReveal = () => {
    if (!video || !Number.isFinite(video.duration)) return;

    const progress = revealProgress;
    const fade = 1 - smoothstep(0.91, 1, progress);
    const hasFinished = progress >= 0.998 && revealTarget >= 1;
    targetTime = Math.max(0.03, video.duration * (1 - progress));

    integralBlindsReveal.style.setProperty('--fg-blinds-progress', progress.toFixed(4));
    integralBlindsReveal.style.setProperty('--fg-blinds-opacity', fade.toFixed(4));
    integralBlindsReveal.style.setProperty('--fg-blinds-cue-opacity', (1 - smoothstep(0.04, 0.28, progress)).toFixed(4));
    integralBlindsReveal.classList.toggle('is-complete', hasFinished);

    if (hasFinished && !revealComplete) {
      revealComplete = true;
      document.documentElement.classList.remove('fg-blinds-reveal-locked');
      window.scrollTo(0, 0);
      window.fensterLenis?.start?.();
      window.setTimeout(() => {
        window.dispatchEvent(new CustomEvent('fg:blinds-reveal-complete'));
      }, 0);
    }

    requestFrame();
  };

  const animateReveal = () => {
    const difference = revealTarget - revealProgress;

    if (Math.abs(difference) > 0.0005) {
      revealProgress += difference * 0.105;
    } else {
      revealProgress = revealTarget;
    }

    updateReveal();

    if (Math.abs(revealTarget - revealProgress) > 0.0005) {
      revealAnimationFrame = window.requestAnimationFrame(animateReveal);
    } else {
      revealAnimationFrame = 0;
    }
  };

  const startRevealAnimation = () => {
    if (!revealAnimationFrame) {
      revealAnimationFrame = window.requestAnimationFrame(animateReveal);
    }
  };

  const consumeRevealScroll = (delta) => {
    if (revealComplete || delta === 0) return false;

    const scrollDistance = Math.max(900, window.innerHeight * 1.55);
    revealTarget = clamp(revealTarget + delta / scrollDistance);
    startRevealAnimation();
    return true;
  };

  const onWheel = (event) => {
    const multiplier = event.deltaMode === 1 ? 18 : event.deltaMode === 2 ? window.innerHeight : 1;
    const delta = event.deltaY * multiplier;

    if (consumeRevealScroll(delta)) {
      event.preventDefault();
    }
  };

  const onKeyDown = (event) => {
    if (revealComplete) return;

    const keyDeltas = {
      ArrowDown: 72,
      ArrowUp: -72,
      PageDown: window.innerHeight * 0.72,
      PageUp: window.innerHeight * -0.72,
      ' ': event.shiftKey ? window.innerHeight * -0.72 : window.innerHeight * 0.72,
      End: window.innerHeight,
    };

    if (Object.prototype.hasOwnProperty.call(keyDeltas, event.key)) {
      event.preventDefault();
      consumeRevealScroll(keyDeltas[event.key]);
    }
  };

  const onTouchStart = (event) => {
    touchY = event.touches[0]?.clientY ?? null;
  };

  const onTouchMove = (event) => {
    const nextY = event.touches[0]?.clientY;
    if (touchY === null || typeof nextY !== 'number') return;

    const delta = touchY - nextY;
    touchY = nextY;

    if (consumeRevealScroll(delta * 1.35)) {
      event.preventDefault();
    }
  };

  const holdPageAtTop = () => {
    if (!revealComplete && window.scrollY !== 0) {
      window.scrollTo(0, 0);
    }
  };

  video.addEventListener('loadedmetadata', () => {
    targetTime = Math.max(0.03, video.duration - 0.03);
    requestFrame();
    updateReveal();
    startRevealAnimation();
  }, { once: true });

  video.addEventListener('seeked', () => {
    seeking = false;
    keyFrame();

    if (Math.abs(video.currentTime - targetTime) >= 0.025) {
      requestFrame();
    }
  });

  window.addEventListener('wheel', onWheel, { passive: false });
  window.addEventListener('keydown', onKeyDown);
  window.addEventListener('touchstart', onTouchStart, { passive: true });
  window.addEventListener('touchmove', onTouchMove, { passive: false });
  window.addEventListener('scroll', holdPageAtTop, { passive: true });
  window.addEventListener('resize', () => {
    updateReveal();
  });

  if (video?.dataset.src) {
    video.src = video.dataset.src;
    video.preload = 'auto';
  }

  if (video.readyState >= 1) {
    targetTime = Math.max(0.03, video.duration - 0.03);
    requestFrame();
    updateReveal();
  } else {
    video.load();
  }
}

const preventHyphenatedWordSplits = () => {
  const skipTags = new Set(['SCRIPT', 'STYLE', 'NOSCRIPT', 'SVG', 'PATH', 'TEXTAREA', 'INPUT', 'SELECT', 'OPTION']);
  const walker = document.createTreeWalker(document.body, 4, {
    acceptNode(node) {
      const parent = node.parentElement;
      if (!parent || skipTags.has(parent.tagName) || parent.closest('[contenteditable="true"]')) {
        return 2;
      }

      return /[A-Za-z]-[A-Za-z]/.test(node.nodeValue || '') ? 1 : 2;
    },
  });

  const nodes = [];
  let node = walker.nextNode();
  while (node) {
    nodes.push(node);
    node = walker.nextNode();
  }

  nodes.forEach((textNode) => {
    textNode.nodeValue = (textNode.nodeValue || '').replace(/([A-Za-z])-([A-Za-z])/g, '$1\u2011$2');
  });
};

if (document.body) {
  preventHyphenatedWordSplits();
} else {
  window.addEventListener('DOMContentLoaded', preventHyphenatedWordSplits, { once: true });
}

// WindowCAD is on another domain, so it cannot read our cookies.  Instead, an
// opaque reference is carried through WindowCAD's separate Tracking field and
// joined to non-PII website events in the Marketing Dashboard when the quote returns.
const websiteTracking = window.fensterWebsiteTracking || {};
const journeyStorageKey = 'fenster_quote_journey_ref';
const visitorStorageKey = 'fenster_website_visitor_id';
const firstTouchStorageKey = 'fenster_website_first_touch';
const trackingStorageLifetime = 90 * 24 * 60 * 60 * 1000;

const trackingConsentAccepted = () => {
  try {
    return window.localStorage.getItem('fenster_cookie_consent') === 'accepted';
  } catch (_error) {
    return false;
  }
};

const trackingConsentRejected = () => {
  try {
    return window.localStorage.getItem('fenster_cookie_consent') === 'rejected';
  } catch (_error) {
    return false;
  }
};

const createJourneyReference = () => {
  const random = window.crypto?.randomUUID?.().replace(/-/g, '').slice(0, 18)
    || `${Date.now().toString(36)}${Math.random().toString(36).slice(2, 12)}`;
  return `FG2-${random.toUpperCase()}`;
};

const createVisitorReference = () => {
  const random = window.crypto?.randomUUID?.().replace(/-/g, '').slice(0, 18)
    || `${Date.now().toString(36)}${Math.random().toString(36).slice(2, 12)}`;
  return `FGV-${random.toUpperCase()}`;
};

const validTrackingReference = (value, prefix) => new RegExp(`^${prefix}-[A-Z0-9-]{8,80}$`, 'i').test(value || '');

const readStoredTrackingValue = (key, validator) => {
  try {
    const raw = window.localStorage.getItem(key);
    const record = raw ? JSON.parse(raw) : null;
    if (record && validator(record.value) && Number(record.expires_at) > Date.now()) return record.value;
    window.localStorage.removeItem(key);
  } catch (_error) {}
  return '';
};

const storeTrackingValue = (key, value) => {
  if (!trackingConsentAccepted()) return;
  try {
    window.localStorage.setItem(key, JSON.stringify({ value, expires_at: Date.now() + trackingStorageLifetime }));
  } catch (_error) {}
};

const journeyReference = () => {
  if (!trackingConsentAccepted()) return '';

  if (trackingConsentAccepted()) {
    const existing = readStoredTrackingValue(journeyStorageKey, (value) => validTrackingReference(value, 'FG2'));
    if (existing) return existing;
    const created = createJourneyReference();
    storeTrackingValue(journeyStorageKey, created);
    return created;
  }

  try {
    const existing = window.sessionStorage.getItem(journeyStorageKey);
    if (validTrackingReference(existing, 'FG2')) return existing;
    const created = createJourneyReference();
    window.sessionStorage.setItem(journeyStorageKey, created);
    return created;
  } catch (_error) {
    return createJourneyReference();
  }
};

const visitorReference = () => {
  if (!trackingConsentAccepted()) return '';
  const existing = readStoredTrackingValue(visitorStorageKey, (value) => validTrackingReference(value, 'FGV'));
  if (existing) return existing;
  const created = createVisitorReference();
  storeTrackingValue(visitorStorageKey, created);
  return created;
};

const currentCampaignContext = () => {
  const parameters = new URLSearchParams(window.location.search);
  return {
    landing_path: window.location.pathname,
    source: parameters.get('utm_source') || '',
    medium: parameters.get('utm_medium') || '',
    campaign: parameters.get('utm_campaign') || '',
    content: parameters.get('utm_content') || '',
    term: parameters.get('utm_term') || '',
    referrer_host: (() => {
      try { return document.referrer ? new URL(document.referrer).hostname : ''; } catch (_error) { return ''; }
    })(),
  };
};

const campaignContext = () => {
  const current = currentCampaignContext();
  if (!trackingConsentAccepted()) return { page_path: window.location.pathname, ...current };

  try {
    const raw = window.localStorage.getItem(firstTouchStorageKey);
    const stored = raw ? JSON.parse(raw) : null;
    if (stored && Number(stored.expires_at) > Date.now() && stored.context) {
      return { page_path: window.location.pathname, ...stored.context };
    }
    const context = { ...current };
    window.localStorage.setItem(firstTouchStorageKey, JSON.stringify({ context, expires_at: Date.now() + trackingStorageLifetime }));
    return { page_path: window.location.pathname, ...context };
  } catch (_error) {
    return { page_path: window.location.pathname, ...current };
  }
};

const trackWebsiteEvent = (event, detail = {}) => {
  const payload = {
    event,
    journey_id: journeyReference(),
    visitor_id: visitorReference(),
    ...campaignContext(),
    ...detail,
  };

  if (!trackingConsentAccepted()) return payload.journey_id;

  window.dataLayer = window.dataLayer || [];
  window.dataLayer.push({ event: `fenster_${event}`, ...payload });
  window.clarity?.('event', `fenster_${event}`);

  if (websiteTracking.endpoint) {
    const body = JSON.stringify(payload);
    if (navigator.sendBeacon) {
      navigator.sendBeacon(websiteTracking.endpoint, new Blob([body], { type: 'text/plain;charset=UTF-8' }));
    } else {
      window.fetch(websiteTracking.endpoint, {
        method: 'POST',
        mode: 'cors',
        keepalive: true,
        headers: { 'Content-Type': 'application/json' },
        body,
      }).catch(() => {});
    }
  }

  return payload.journey_id;
};

const windowCadUrlWithReference = (value) => {
  if (!value || !/windowsoftware\.co\.uk\/windowcad7/i.test(value)) return value;

  try {
    const url = new URL(value, window.location.href);
    const trackingValue = trackingConsentRejected() ? 'rejected-cookies' : (journeyReference() || 'cookie-consent-not-accepted');
    url.searchParams.set(websiteTracking.referenceParameter || 'reference', trackingValue);
    return url.toString();
  } catch (_error) {
    return value;
  }
};

document.querySelectorAll('a[href*="windowsoftware.co.uk/windowcad7/"]').forEach((link) => {
  link.href = windowCadUrlWithReference(link.href);
  link.addEventListener('click', () => {
    link.href = windowCadUrlWithReference(link.href);
    trackWebsiteEvent('quote_opened', {
      cta: (link.textContent || 'WindowCAD link').trim().slice(0, 120),
      product_collection: new URL(link.href).searchParams.get('productCollection') || '',
    });
  });
});

document.querySelectorAll('[data-fg-journey-ref]').forEach((field) => {
  field.value = journeyReference();
});

document.querySelectorAll('[data-fg-visitor-id]').forEach((field) => {
  field.value = visitorReference();
});

if (trackingConsentAccepted()) {
  trackWebsiteEvent('visitor_seen');
  trackWebsiteEvent('page_view');
}

const pageTrackingStartedAt = Date.now();
let pageEngagementRecorded = false;
const recordPageEngagement = () => {
  if (pageEngagementRecorded || !trackingConsentAccepted()) return;
  pageEngagementRecorded = true;
  trackWebsiteEvent('page_engaged', {
    page_duration_seconds: Math.min(1800, Math.max(1, Math.round((Date.now() - pageTrackingStartedAt) / 1000))),
  });
};

window.addEventListener('pagehide', recordPageEngagement, { once: true });
document.addEventListener('visibilitychange', () => {
  if (document.visibilityState === 'hidden') recordPageEngagement();
});

document.addEventListener('click', (event) => {
  const phoneLink = event.target.closest('a[href^="tel:"]');
  if (phoneLink) {
    trackWebsiteEvent('phone_click', { cta: (phoneLink.textContent || 'Phone').trim().slice(0, 120) });
  }

  const emailLink = event.target.closest('a[href^="mailto:"]');
  if (emailLink) {
    trackWebsiteEvent('email_click', { cta: (emailLink.textContent || 'Email').trim().slice(0, 120) });
  }

  const pageLink = event.target.closest('a[href]');
  if (!pageLink || phoneLink || emailLink || /windowsoftware\.co\.uk\/windowcad7/i.test(pageLink.href) || pageLink.getAttribute('href')?.startsWith('#')) return;

  try {
    const destination = new URL(pageLink.href, window.location.href);
    trackWebsiteEvent('link_click', {
      cta: (pageLink.textContent || pageLink.getAttribute('aria-label') || 'Link').trim().slice(0, 120),
      link_target: destination.origin === window.location.origin ? destination.pathname : destination.origin,
    });
  } catch (_error) {}
});

// Commercial CTA interactions are distinct from ordinary navigation. Labels
// and destinations only: never form values or other customer-entered data.
document.addEventListener('click', (event) => {
  const action = event.target.closest('a.button, button.button, [data-fg-audience-choice]');
  if (!action || action.matches('[data-fg-cookie-accept], [data-fg-cookie-decline]') || action.matches('[type="submit"]')) return;
  const label = (action.textContent || action.getAttribute('aria-label') || 'Website action').trim().replace(/\s+/g, ' ').slice(0, 120);
  let target = '';
  if (action instanceof HTMLAnchorElement && action.href) {
    try {
      const url = new URL(action.href, window.location.href);
      target = url.origin === window.location.origin ? url.pathname : url.origin;
    } catch (_error) {}
  }
  trackWebsiteEvent('cta_click', { cta: label, link_target: target });
});

const trackedScrollMilestones = new Set();
const recordScrollMilestones = () => {
  if (!trackingConsentAccepted()) return;
  const documentHeight = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
  const visibleBottom = window.scrollY + window.innerHeight;
  const percent = documentHeight > 0 ? Math.min(100, Math.round((visibleBottom / documentHeight) * 100)) : 0;
  [25, 50, 75, 90].forEach((milestone) => {
    if (percent < milestone || trackedScrollMilestones.has(milestone)) return;
    trackedScrollMilestones.add(milestone);
    trackWebsiteEvent('scroll_depth', { cta: `${milestone}% page depth`, event_value: milestone });
  });
};
window.addEventListener('scroll', recordScrollMilestones, { passive: true });
window.addEventListener('load', recordScrollMilestones, { once: true });

const enquiryForms = [...document.querySelectorAll('[data-fg-enquiry-form]')];
const ukPostcodePattern = /^(GIR\s?0AA|[A-Z]{1,2}[0-9][A-Z0-9]?\s?[0-9][A-Z]{2})$/i;

const isValidUkPhone = (value) => {
  const phone = value.trim();
  if (!/^[0-9+().\s-]{10,24}$/.test(phone)) return false;
  if ((phone.match(/\+/g) || []).length > 1 || (phone.includes('+') && !phone.startsWith('+'))) return false;

  const digits = phone.replace(/\D+/g, '');
  const national = digits.startsWith('0044')
    ? `0${digits.slice(4)}`
    : digits.startsWith('44')
      ? `0${digits.slice(2)}`
      : digits;

  return /^0[1-9][0-9]{8,9}$/.test(national);
};

enquiryForms.forEach((form) => {
  const feedback = form.querySelector('[data-fg-enquiry-feedback]');
  const submitButton = form.querySelector('button[type="submit"]');
  const submitLabel = submitButton?.querySelector('span');
  const originalLabel = submitLabel?.textContent || 'Send enquiry';
  const audienceGate = form.querySelector('[data-fg-audience-gate]');
  const audienceBody = form.querySelector('[data-fg-audience-body]');
  const audienceChoices = [...form.querySelectorAll('[data-fg-audience-choice]')];
  const projectTypeField = form.querySelector('[data-fg-project-type]');
  const steps = [...form.querySelectorAll('[data-fg-enquiry-step]')];
  const progress = form.querySelector('[data-fg-enquiry-progress]');
  const progressBar = progress?.querySelector('span');
  const progressText = progress?.querySelector('small');
  const stepControls = form.querySelector('[data-fg-enquiry-step-controls]');
  const previousStepButton = form.querySelector('[data-fg-enquiry-prev]');
  const nextStepButton = form.querySelector('[data-fg-enquiry-next]');
  let activeStep = 0;
  let formStartRecorded = false;
  let formErrorRecorded = false;

  const formContext = () => form.dataset.source || form.getAttribute('aria-label') || 'Website enquiry form';
  const recordFormStart = () => {
    if (formStartRecorded) return;
    formStartRecorded = true;
    trackWebsiteEvent('form_started', { cta: formContext() });
  };

  form.addEventListener('focusin', (event) => {
    if (event.target.matches('input, select, textarea')) recordFormStart();
  });
  form.addEventListener('invalid', (event) => {
    if (formErrorRecorded || !event.target.name) return;
    formErrorRecorded = true;
    trackWebsiteEvent('form_validation_error', { cta: `${formContext()}: ${event.target.name}` });
  }, true);

  const isSteppedForm = () => steps.length > 1;
  const validationFields = [
    ...form.querySelectorAll('input[name="email"], input[name="phone"], input[name="location"]'),
  ];

  if (audienceGate && audienceBody && audienceChoices.length && projectTypeField) {
    form.classList.add('fg-enquiry-form--audience-gated');

    const chooseAudience = (choice) => {
      audienceChoices.forEach((button) => {
        const active = button === choice;
        button.classList.toggle('is-active', active);
        button.setAttribute('aria-pressed', active ? 'true' : 'false');
      });

      const projectType = choice.dataset.projectType || choice.textContent?.trim() || projectTypeField.value;
      projectTypeField.value = projectType;
      form.classList.add('is-audience-selected');
      audienceBody.removeAttribute('hidden');
      audienceBody.querySelector('input, select, textarea')?.focus?.({ preventScroll: true });
    };

    audienceChoices.forEach((choice) => {
      choice.addEventListener('click', () => chooseAudience(choice));
    });
  }

  const validateContactField = (field) => {
    field.setCustomValidity('');
    const value = field.value.trim();

    if (!value) return;

    if (field.name === 'email' && field.validity.typeMismatch) {
      field.setCustomValidity('Enter a valid email address.');
    }

    if (field.name === 'phone' && !isValidUkPhone(value)) {
      field.setCustomValidity('Enter a valid UK phone number.');
    }

    if (field.name === 'location' && !ukPostcodePattern.test(value)) {
      field.setCustomValidity('Enter a valid UK postcode.');
    }
  };

  const validateContactFields = () => {
    validationFields.forEach(validateContactField);
  };

  validationFields.forEach((field) => {
    field.addEventListener('input', () => validateContactField(field));
    field.addEventListener('blur', () => validateContactField(field));
  });

  const updateSteps = (nextStep = activeStep) => {
    activeStep = clamp(nextStep, 0, Math.max(0, steps.length - 1));
    const stepped = isSteppedForm();

    form.classList.toggle('is-stepped', stepped);
    steps.forEach((step, index) => {
      step.toggleAttribute('hidden', stepped && index !== activeStep);
      step.classList.toggle('is-active', !stepped || index === activeStep);
    });

    if (progressBar) {
      progressBar.style.transform = `scaleX(${steps.length ? (activeStep + 1) / steps.length : 1})`;
    }

    if (progressText) {
      const label = steps[activeStep]?.dataset.stepLabel || '';
      progressText.textContent = `Step ${activeStep + 1} of ${steps.length}${label ? ` - ${label}` : ''}`;
    }

    if (stepControls) {
      stepControls.hidden = !stepped || activeStep === steps.length - 1;
    }

    if (previousStepButton) {
      previousStepButton.hidden = activeStep === 0;
    }
  };

  const getInvalidStepIndex = (step) => {
    const fields = [...step.querySelectorAll('input, select, textarea')].filter((field) => (
      !field.disabled
      && field.type !== 'hidden'
      && field.type !== 'submit'
      && field.type !== 'button'
    ));

    return fields.findIndex((field) => !field.checkValidity());
  };

  const validateActiveStep = () => {
    const step = steps[activeStep];
    if (!step) return true;

    const invalidIndex = getInvalidStepIndex(step);
    if (invalidIndex === -1) return true;

    const invalidField = [...step.querySelectorAll('input, select, textarea')].filter((field) => (
      !field.disabled
      && field.type !== 'hidden'
      && field.type !== 'submit'
      && field.type !== 'button'
    ))[invalidIndex];
    invalidField?.reportValidity?.();
    invalidField?.focus?.({ preventScroll: true });
    return false;
  };

  const showStepForInvalidField = () => {
    if (!isSteppedForm()) return false;

    const invalidField = [...form.querySelectorAll('input, select, textarea')].find((field) => (
      !field.disabled
      && field.type !== 'hidden'
      && field.type !== 'submit'
      && field.type !== 'button'
      && !field.checkValidity()
    ));

    if (!invalidField) return false;

    const invalidStep = steps.findIndex((step) => step.contains(invalidField));
    if (invalidStep !== -1 && invalidStep !== activeStep) {
      updateSteps(invalidStep);
      window.requestAnimationFrame(() => invalidField.reportValidity?.());
      return true;
    }

    return false;
  };

  nextStepButton?.addEventListener('click', () => {
    if (!isSteppedForm() || !validateActiveStep()) return;
    updateSteps(activeStep + 1);
    steps[activeStep]?.querySelector('input, select, textarea')?.focus?.({ preventScroll: true });
  });

  previousStepButton?.addEventListener('click', () => {
    if (!isSteppedForm()) return;
    updateSteps(activeStep - 1);
    steps[activeStep]?.querySelector('input, select, textarea')?.focus?.({ preventScroll: true });
  });

  updateSteps(0);

  const showFeedback = (type, title, copy) => {
    if (!feedback) return;

    feedback.replaceChildren();
    const icon = document.createElement('span');
    const content = document.createElement('div');
    const heading = document.createElement('strong');
    const message = document.createElement('p');

    icon.className = 'fg-enquiry-form__feedback-icon';
    icon.setAttribute('aria-hidden', 'true');
    icon.textContent = type === 'success' ? '✓' : '!';
    heading.textContent = title;
    message.textContent = copy;
    content.append(heading, message);
    feedback.append(icon, content);
    feedback.hidden = false;
    feedback.className = `fg-enquiry-form__feedback fg-enquiry-form__feedback--${type}`;
    feedback.setAttribute('role', type === 'success' ? 'status' : 'alert');
    feedback.setAttribute('aria-live', type === 'success' ? 'polite' : 'assertive');
  };

  form.addEventListener('submit', async (event) => {
    recordFormStart();
    form.querySelectorAll('[data-fg-journey-ref]').forEach((field) => { field.value = journeyReference(); });
    form.querySelectorAll('[data-fg-visitor-id]').forEach((field) => { field.value = visitorReference(); });
    validateContactFields();

    if (showStepForInvalidField()) {
      event.preventDefault();
      return;
    }

    if (!form.reportValidity()) return;

    const ajaxUrl = form.dataset.ajaxUrl;
    if (!ajaxUrl || !window.fetch || !window.FormData) return;

    event.preventDefault();

    if (form.classList.contains('is-submitting') || form.classList.contains('is-submitted')) {
      return;
    }

    form.classList.add('is-submitting');
    form.setAttribute('aria-busy', 'true');
    const submittedScrollY = window.scrollY;
    if (submitButton) submitButton.disabled = true;
    if (submitLabel) submitLabel.textContent = 'Sending securely…';
    if (feedback) feedback.hidden = true;

    try {
      const response = await fetch(ajaxUrl, {
        method: 'POST',
        body: new FormData(form),
        credentials: 'same-origin',
        headers: {
          Accept: 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
      });
      const payload = await response.json();

      if (!response.ok || !payload.success) {
        throw new Error(payload?.data?.message || 'We could not send your enquiry. Please try again.');
      }

      const result = payload.data || {};
      const submittedHeight = Math.ceil(form.getBoundingClientRect().height);
      const smoothScroll = window.fensterLenis;
      submitButton?.blur();
      smoothScroll?.stop?.();
      form.style.minHeight = `${submittedHeight}px`;
      form.reset();
      form.classList.add('is-submitted');
      showFeedback(
        'success',
        result.message || 'Thanks — your enquiry has been received.',
        result.copy || 'Your project details are safely with the Fenster team.',
      );
      const restoreSubmissionPosition = () => {
        smoothScroll?.scrollTo?.(submittedScrollY, { immediate: true, force: true });
        window.scrollTo({ top: submittedScrollY, left: window.scrollX, behavior: 'auto' });
      };
      restoreSubmissionPosition();
      window.requestAnimationFrame(() => {
        restoreSubmissionPosition();
        window.setTimeout(() => {
          restoreSubmissionPosition();
          smoothScroll?.start?.();
        }, 80);
      });
    } catch (error) {
      showFeedback(
        'error',
        'Your enquiry has not been sent yet.',
        error instanceof Error ? error.message : 'Please try again or contact the Fenster team directly.',
      );
    } finally {
      form.classList.remove('is-submitting');
      form.removeAttribute('aria-busy');
      if (submitButton) submitButton.disabled = false;
      if (submitLabel) submitLabel.textContent = originalLabel;
    }
  });
});

document.querySelectorAll('[data-fg-consultation-booking]').forEach((booking) => {
  const form = booking.closest('[data-fg-enquiry-form]');
  const calendar = booking.querySelector('[data-fg-consultation-calendar]');
  const times = booking.querySelector('[data-fg-consultation-times]');
  const selection = booking.querySelector('[data-fg-consultation-selection]');
  const dateField = form?.querySelector('[data-fg-consultation-date]');
  const timeField = form?.querySelector('[data-fg-consultation-time]');
  const stages = booking.querySelectorAll('[data-fg-consultation-stage]');
  if (!form || !calendar || !times || !selection || !dateField || !timeField || !stages.length) return;

  let bankHolidays = [];
  try {
    bankHolidays = JSON.parse(booking.dataset.fgConsultationBankHolidays || '[]');
  } catch (error) {
    bankHolidays = [];
  }
  const bankHolidayDates = new Set(Array.isArray(bankHolidays) ? bankHolidays : []);

  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const lastBookableDate = new Date(today);
  lastBookableDate.setDate(lastBookableDate.getDate() + 30);
  let visibleMonth = new Date(today.getFullYear(), today.getMonth(), 1);
  let selectedDate = null;
  let selectedTime = '';
  const showStage = (stageName, focusSelector = '') => {
    stages.forEach((stage) => {
      stage.hidden = stage.dataset.fgConsultationStage !== stageName;
    });
    booking.dataset.fgConsultationActiveStage = stageName;
    if (focusSelector) window.requestAnimationFrame(() => booking.querySelector(focusSelector)?.focus());
  };
  const isoDate = (date) => [date.getFullYear(), String(date.getMonth() + 1).padStart(2, '0'), String(date.getDate()).padStart(2, '0')].join('-');
  const isBookable = (date) => date >= today && date <= lastBookableDate && date.getDay() !== 0 && date.getDay() !== 6 && !bankHolidayDates.has(isoDate(date));
  const readableDate = (date) => new Intl.DateTimeFormat('en-GB', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).format(date);
  const updateSelection = () => {
    if (!selectedDate || !selectedTime) return;
    selection.textContent = `Preferred consultation: ${readableDate(selectedDate)} at ${new Intl.DateTimeFormat('en-GB', { hour: 'numeric', hour12: true }).format(new Date(`2000-01-01T${selectedTime}:00`)).toLowerCase()}`;
  };
  const renderCalendar = () => {
    const monthStart = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth(), 1);
    const monthEnd = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 0);
    const canGoBack = visibleMonth.getFullYear() > today.getFullYear() || visibleMonth.getMonth() > today.getMonth();
    const canGoForward = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 1) <= lastBookableDate;
    const heading = new Intl.DateTimeFormat('en-GB', { month: 'long', year: 'numeric' }).format(monthStart);
    const firstOffset = (monthStart.getDay() + 6) % 7;
    let days = '<div class="fg-consultation-booking__weekdays" aria-hidden="true"><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span></div><div class="fg-consultation-booking__days">';
    days += '<span></span>'.repeat(firstOffset);
    for (let day = 1; day <= monthEnd.getDate(); day += 1) {
      const date = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth(), day);
      const bookable = isBookable(date);
      const selected = selectedDate && isoDate(date) === isoDate(selectedDate);
      days += `<button type="button" data-fg-consultation-day="${isoDate(date)}" ${bookable ? '' : 'disabled'} aria-pressed="${selected ? 'true' : 'false'}" aria-label="${readableDate(date)}">${day}</button>`;
    }
    days += '<span></span>'.repeat(42 - firstOffset - monthEnd.getDate());
    days += '</div>';
    calendar.innerHTML = `<div class="fg-consultation-booking__calendar-head"><button type="button" data-fg-consultation-previous ${canGoBack ? '' : 'disabled'} aria-label="Previous month">←</button><strong>${heading}</strong><button type="button" data-fg-consultation-next ${canGoForward ? '' : 'disabled'} aria-label="Next month">→</button></div>${days}`;
    calendar.querySelector('[data-fg-consultation-previous]')?.addEventListener('click', () => { visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() - 1, 1); renderCalendar(); });
    calendar.querySelector('[data-fg-consultation-next]')?.addEventListener('click', () => { visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 1); renderCalendar(); });
    calendar.querySelectorAll('[data-fg-consultation-day]').forEach((button) => button.addEventListener('click', () => {
      selectedDate = new Date(`${button.dataset.fgConsultationDay}T00:00:00`);
      dateField.value = button.dataset.fgConsultationDay || '';
      selectedTime = '';
      timeField.value = '';
      booking.querySelectorAll('[data-fg-consultation-time-option]').forEach((option) => option.setAttribute('aria-pressed', 'false'));
      renderCalendar();
      showStage('time', '[data-fg-consultation-time-option]');
    }));
  };
  booking.querySelectorAll('[data-fg-consultation-time-option]').forEach((button) => button.addEventListener('click', () => {
    selectedTime = button.dataset.time || '';
    timeField.value = selectedTime;
    booking.querySelectorAll('[data-fg-consultation-time-option]').forEach((option) => option.setAttribute('aria-pressed', option === button ? 'true' : 'false'));
    updateSelection();
    showStage('details', 'input[name="name"]');
  }));
  booking.querySelectorAll('[data-fg-consultation-back]').forEach((button) => button.addEventListener('click', () => {
    showStage(button.dataset.fgConsultationBack || 'date');
  }));
  showStage('date');
  renderCalendar();
});

if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const lenis = new Lenis({
    anchors: {
      offset: -88,
    },
    autoRaf: true,
    lerp: 0.075,
    smoothWheel: true,
    syncTouch: false,
    wheelMultiplier: 0.95,
    prevent: (node) => node.closest?.('iframe, [data-no-smooth-scroll], [data-lenis-prevent]'),
  });

  window.fensterLenis = lenis;
  globalThis.fensterLenis = lenis;
  document.documentElement.setAttribute('data-lenis-ready', 'true');

  if (document.documentElement.classList.contains('fg-blinds-reveal-locked')) {
    lenis.stop();
    window.addEventListener('fg:blinds-reveal-complete', () => lenis.start(), { once: true });
  }
}

const navToggle = document.querySelector('.site-nav-toggle');
const siteHeader = document.querySelector('.site-header');

if (navToggle && siteHeader) {
  const mobileAccordionItems = [...siteHeader.querySelectorAll('[data-mobile-accordion-item]')];
  const mobileNav = siteHeader.querySelector('[data-mobile-accordion-nav]');
  const desktopNavItems = [...siteHeader.querySelectorAll('.site-nav__item.has-children')];
  const getDirectDesktopPanel = (item) => [...(item?.children || [])].find((child) => (
    child.classList?.contains('site-nav__mega') || child.classList?.contains('site-nav__sublist')
  ));

  desktopNavItems.forEach((item) => {
    const panel = getDirectDesktopPanel(item);
    if (!panel) return;

    let closeTimer = 0;
    const openPanel = () => {
      window.clearTimeout(closeTimer);
      panel.hidden = false;
    };
    const closePanel = () => {
      window.clearTimeout(closeTimer);
      closeTimer = window.setTimeout(() => {
        if (!item.matches(':hover') && !item.contains(document.activeElement)) {
          panel.hidden = true;
        }
      }, 80);
    };

    item.addEventListener('pointerenter', openPanel);
    item.addEventListener('pointerleave', closePanel);
    item.addEventListener('focusin', openPanel);
    item.addEventListener('focusout', closePanel);
  });

  const findDesktopNavItem = (target) => target.closest?.('.site-nav__item.has-children');
  const setDesktopPanelHidden = (item, isHidden) => {
    const panel = getDirectDesktopPanel(item);
    if (panel) {
      panel.hidden = isHidden;
    }
  };

  siteHeader.addEventListener('pointerover', (event) => {
    const item = findDesktopNavItem(event.target);
    if (item && siteHeader.contains(item)) {
      setDesktopPanelHidden(item, false);
    }
  });

  siteHeader.addEventListener('mouseover', (event) => {
    const item = findDesktopNavItem(event.target);
    if (item && siteHeader.contains(item)) {
      setDesktopPanelHidden(item, false);
    }
  });

  siteHeader.addEventListener('focusin', (event) => {
    const item = findDesktopNavItem(event.target);
    if (item && siteHeader.contains(item)) {
      setDesktopPanelHidden(item, false);
    }
  });

  siteHeader.addEventListener('pointerout', (event) => {
    const item = findDesktopNavItem(event.target);
    if (!item || item.contains(event.relatedTarget)) return;
    window.setTimeout(() => {
      if (!item.matches(':hover') && !item.contains(document.activeElement)) {
        setDesktopPanelHidden(item, true);
      }
    }, 80);
  });

  siteHeader.addEventListener('mouseout', (event) => {
    const item = findDesktopNavItem(event.target);
    if (!item || item.contains(event.relatedTarget)) return;
    window.setTimeout(() => {
      if (!item.matches(':hover') && !item.contains(document.activeElement)) {
        setDesktopPanelHidden(item, true);
      }
    }, 80);
  });

  siteHeader.addEventListener('focusout', (event) => {
    const item = findDesktopNavItem(event.target);
    if (!item || item.contains(event.relatedTarget)) return;
    window.setTimeout(() => {
      if (!item.matches(':hover') && !item.contains(document.activeElement)) {
        setDesktopPanelHidden(item, true);
      }
    }, 80);
  });

  const setMobileItemOpen = (item, isOpen) => {
    item.classList.toggle('is-open', isOpen);
    item.querySelector(':scope > [data-mobile-accordion-toggle]')?.setAttribute('aria-expanded', String(isOpen));
    const panel = item.querySelector(':scope > .site-mobile-nav__panel');
    if (panel) {
      panel.hidden = !isOpen;
    }
  };

  const closeMobileAccordion = () => {
    mobileAccordionItems.forEach((item) => {
      setMobileItemOpen(item, false);
    });
  };

  navToggle.addEventListener('click', () => {
    const isOpen = siteHeader.classList.toggle('is-nav-open');
    document.documentElement.classList.toggle('is-mobile-nav-open', isOpen);
    navToggle.setAttribute('aria-expanded', String(isOpen));
    if (mobileNav) {
      mobileNav.hidden = !isOpen;
    }
    const toggleText = navToggle.querySelector('span');
    if (toggleText) {
      toggleText.textContent = isOpen ? 'Close' : 'Menu';
    }

    if (!isOpen) {
      closeMobileAccordion();
    }
  });

  mobileNav?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      siteHeader.classList.remove('is-nav-open');
      document.documentElement.classList.remove('is-mobile-nav-open');
      navToggle.setAttribute('aria-expanded', 'false');
      if (mobileNav) mobileNav.hidden = true;
      const toggleText = navToggle.querySelector('span');
      if (toggleText) toggleText.textContent = 'Menu';
      closeMobileAccordion();
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape' || !siteHeader.classList.contains('is-nav-open')) return;
    navToggle.click();
    navToggle.focus();
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth <= 860 || !siteHeader.classList.contains('is-nav-open')) return;
    siteHeader.classList.remove('is-nav-open');
    document.documentElement.classList.remove('is-mobile-nav-open');
    navToggle.setAttribute('aria-expanded', 'false');
    if (mobileNav) mobileNav.hidden = true;
    const toggleText = navToggle.querySelector('span');
    if (toggleText) toggleText.textContent = 'Menu';
    closeMobileAccordion();
  });

  mobileAccordionItems.forEach((item) => {
    const toggle = item.querySelector(':scope > [data-mobile-accordion-toggle]');
    toggle?.addEventListener('click', () => {
      const parentPanel = item.parentElement?.closest('[data-mobile-accordion-item]');
      const siblingItems = parentPanel
        ? [...parentPanel.querySelectorAll(':scope > .site-mobile-nav__panel > [data-mobile-accordion-item]')]
        : [...siteHeader.querySelectorAll('.site-mobile-nav > [data-mobile-accordion-item]')];
      const shouldOpen = !item.classList.contains('is-open');

      siblingItems.forEach((sibling) => {
        if (sibling === item) return;
        setMobileItemOpen(sibling, false);
        sibling.querySelectorAll('[data-mobile-accordion-item]').forEach((nestedItem) => {
          setMobileItemOpen(nestedItem, false);
        });
      });

      setMobileItemOpen(item, shouldOpen);
    });
  });
}

document.querySelectorAll('.fg-product-why__accordion, .fg-product-faq__items').forEach((accordion) => {
  const items = [...accordion.querySelectorAll('details')];
  const panels = [...accordion.querySelectorAll('.fg-product-why__answer, .fg-product-faq__answer')];

  const syncPanelHeight = () => {
    if (!panels.length) return;

    accordion.style.removeProperty('--fg-accordion-panel-height');
    const tallest = panels.reduce((height, panel) => {
      panel.style.height = 'auto';
      const panelHeight = panel.scrollHeight;
      panel.style.removeProperty('height');

      return Math.max(height, panelHeight);
    }, 0);

    accordion.style.setProperty('--fg-accordion-panel-height', `${Math.ceil(tallest + 10)}px`);
  };

  syncPanelHeight();
  window.addEventListener('resize', syncPanelHeight);
  window.addEventListener('load', syncPanelHeight);

  items.forEach((item) => {
    const summary = item.querySelector('summary');
    if (!summary) return;

    summary.addEventListener('click', (event) => {
      event.preventDefault();
      const shouldOpen = !item.open;
      items.forEach((otherItem) => {
        otherItem.open = false;
      });

      item.open = shouldOpen;
      syncPanelHeight();
    });
  });

  if ('ResizeObserver' in window) {
    const resizeObserver = new ResizeObserver(syncPanelHeight);
    panels.forEach((panel) => resizeObserver.observe(panel));
  }
});

document.querySelectorAll('[data-fg-window-handles]').forEach((handleBlock) => {
  const buttons = [...handleBlock.querySelectorAll('[data-fg-handle-finish]')];
  const images = [...handleBlock.querySelectorAll('[data-fg-handle-image]')];
  const panels = [...handleBlock.querySelectorAll('[data-fg-handle-panel]')];

  if (!buttons.length || !images.length || !panels.length) return;

  const activateFinish = (targetIndex) => {
    buttons.forEach((button) => {
      const isActive = button.getAttribute('data-fg-handle-finish') === targetIndex;
      button.classList.toggle('is-active', isActive);
      button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
    });

    images.forEach((image) => {
      image.classList.toggle('is-active', image.getAttribute('data-fg-handle-image') === targetIndex);
    });

    panels.forEach((panel) => {
      panel.hidden = panel.getAttribute('data-fg-handle-panel') !== targetIndex;
    });
  };

  buttons.forEach((button) => {
    button.addEventListener('click', () => {
      activateFinish(button.getAttribute('data-fg-handle-finish') || '0');
    });
  });
});

document.querySelectorAll('[data-fg-obscure-glass]').forEach((visualiser) => {
  const stage = visualiser.querySelector('.fg-obscure-stage');
  const viewport = visualiser.querySelector('[data-fg-obscure-tilt]');
  const buttons = [...visualiser.querySelectorAll('[data-fg-obscure-option]')];
  const nameTarget = visualiser.querySelector('[data-fg-obscure-active-name]');
  const copyTarget = visualiser.querySelector('[data-fg-obscure-active-copy]');
  const privacyTarget = visualiser.querySelector('[data-fg-obscure-active-privacy]');
  const backgroundToggle = visualiser.querySelector('[data-fg-obscure-background-toggle]');
  const splitControl = visualiser.querySelector('[data-fg-obscure-split]');
  const backgroundNames = ['cat', 'house'];
  let backgroundIndex = 0;

  if (!stage || !viewport || !buttons.length) return;

  const setSplit = (value) => {
    const split = clamp(Number.parseFloat(value), 0, 100);
    viewport.style.setProperty('--split', `${split.toFixed(1)}%`);
  };

  const activateBackground = (name) => {
    const image = name === 'house' ? stage.dataset.houseImage : stage.dataset.catImage;
    if (image) {
      stage.style.setProperty('--scene-image', `url("${image}")`);
    }

    stage.dataset.activeBackground = name;
    if (backgroundToggle) {
      backgroundToggle.textContent = name === 'cat' ? 'Show house background' : 'Show Legend background';
    }
  };

  const activate = (button) => {
    const texture = button.dataset.texture || '';
    const name = button.dataset.name || 'Obscured glass';
    const key = button.dataset.key || name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    const privacy = button.dataset.privacy || '0';
    const copy = button.dataset.copy || '';

    buttons.forEach((option) => {
      const active = option === button;
      option.classList.toggle('is-active', active);
      option.setAttribute('aria-pressed', active ? 'true' : 'false');
    });

    if (texture) {
      stage.style.setProperty('--active-texture', texture);
    }

    stage.style.setProperty('--privacy', privacy);
    stage.dataset.activeGlass = key;
    if (nameTarget) nameTarget.textContent = name;
    if (privacyTarget) privacyTarget.textContent = privacy === '0' ? 'Decorative texture' : `Privacy ${privacy}`;
    if (copyTarget) copyTarget.textContent = copy;
  };

  buttons.forEach((button) => {
    button.addEventListener('click', () => activate(button));
    button.addEventListener('keydown', (event) => {
      if (!['Enter', ' '].includes(event.key)) return;
      event.preventDefault();
      activate(button);
    });
  });

  splitControl?.addEventListener('input', () => {
    setSplit(splitControl.value);
  });

  backgroundToggle?.addEventListener('click', () => {
    backgroundIndex = (backgroundIndex + 1) % backgroundNames.length;
    activateBackground(backgroundNames[backgroundIndex]);
  });

  activateBackground(backgroundNames[backgroundIndex]);
  setSplit(splitControl?.value || 54);
});

document.querySelectorAll('[data-fg-colour-carousel]').forEach((carousel) => {
  const track = carousel.querySelector('[data-fg-colour-carousel-track]');
  const slides = [...carousel.querySelectorAll('[data-fg-colour-slide]')];
  const prev = carousel.querySelector('[data-fg-colour-prev]');
  const next = carousel.querySelector('[data-fg-colour-next]');
  const count = carousel.querySelector('[data-fg-colour-count]');
  let activeIndex = 0;
  let pointerStartX = null;
  let pointerId = null;
  let dragProgress = 0;
  let suppressSlideClick = false;

  if (!track || !slides.length) return;

  carousel.setAttribute('tabindex', '0');
  carousel.querySelectorAll('img').forEach((img) => {
    img.draggable = false;
  });

  const getWrappedOffset = (index) => {
    let offset = index - activeIndex;
    const half = slides.length / 2;

    if (offset > half) offset -= slides.length;
    if (offset < -half) offset += slides.length;

    return offset;
  };

  const getScale = (absOffset) => {
    if (absOffset < 0.05) return 1;
    if (absOffset < 1) return 1 - (absOffset * 0.18);
    return Math.max(0.68, 0.82 - ((absOffset - 1) * 0.14));
  };

  const render = (progress = 0) => {
    slides.forEach((slide, index) => {
      const offset = getWrappedOffset(index) + progress;
      const visibleOffset = Math.max(-2, Math.min(2, offset));
      const absOffset = Math.abs(offset);

      slide.style.setProperty('--offset', visibleOffset);
      slide.style.setProperty('--abs-offset', Math.min(2, absOffset));
      slide.style.setProperty('--scale', String(getScale(absOffset)));
      slide.style.setProperty('--z', String(Math.round(100 - (absOffset * 10))));
      slide.classList.toggle('is-active', absOffset < 0.5);
      slide.classList.toggle('is-near', absOffset >= 0.5 && absOffset < 1.5);
      slide.classList.toggle('is-hidden', absOffset > 2);
      slide.setAttribute('aria-hidden', absOffset < 0.5 ? 'false' : 'true');
    });
  };

  const update = () => {
    dragProgress = 0;
    render();

    if (count) {
      count.textContent = `${String(activeIndex + 1).padStart(2, '0')} / ${String(slides.length).padStart(2, '0')}`;
    }
  };

  const goToPrevious = () => {
    activeIndex = (activeIndex - 1 + slides.length) % slides.length;
    update();
  };

  const goToNext = () => {
    activeIndex = (activeIndex + 1) % slides.length;
    update();
  };

  const goBy = (steps) => {
    activeIndex = (activeIndex - steps + slides.length * 100) % slides.length;
    update();
  };

  const setDragProgress = (dragDistance) => {
    const step = Math.min(150, Math.max(96, carousel.clientWidth * 0.16));
    dragProgress = dragDistance / step;
    render(dragProgress);
  };

  const stopDragging = () => {
    pointerStartX = null;
    pointerId = null;
    dragProgress = 0;
    carousel.classList.remove('is-dragging');
    window.removeEventListener('pointermove', handlePointerMove);
    window.removeEventListener('pointerup', handlePointerUp);
    window.removeEventListener('pointercancel', handlePointerCancel);
  };

  const handlePointerMove = (event) => {
    if (pointerStartX === null || event.pointerId !== pointerId) return;
    const diff = event.clientX - pointerStartX;
    setDragProgress(diff);
  };

  const handlePointerUp = (event) => {
    if (pointerStartX === null || event.pointerId !== pointerId) return;
    const diff = event.clientX - pointerStartX;
    suppressSlideClick = Math.abs(diff) > 10;
    const releaseProgress = dragProgress;
    const snapSteps = Math.round(releaseProgress);

    stopDragging();
    if (snapSteps !== 0) {
      goBy(snapSteps);
    } else {
      update();
    }

    window.setTimeout(() => {
      suppressSlideClick = false;
    }, 160);
  };

  const handlePointerCancel = () => {
    stopDragging();
    update();
  };

  prev?.addEventListener('click', () => {
    goToPrevious();
  });

  next?.addEventListener('click', () => {
    goToNext();
  });

  slides.forEach((slide, index) => {
    slide.addEventListener('click', () => {
      if (suppressSlideClick) return;
      if (index === activeIndex) return;
      activeIndex = index;
      update();
    });
  });

  carousel.addEventListener('keydown', (event) => {
    if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
    event.preventDefault();
    if (event.key === 'ArrowLeft') {
      goToPrevious();
    } else {
      goToNext();
    }
  });

  carousel.addEventListener('pointerdown', (event) => {
    if (event.target.closest('.fg-colour-carousel__controls')) return;
    pointerStartX = event.clientX;
    pointerId = event.pointerId;
    dragProgress = 0;
    suppressSlideClick = false;
    carousel.classList.add('is-dragging');
    carousel.setPointerCapture?.(event.pointerId);
    window.addEventListener('pointermove', handlePointerMove);
    window.addEventListener('pointerup', handlePointerUp);
    window.addEventListener('pointercancel', handlePointerCancel);
  });

  update();
});

document.querySelectorAll('[data-fg-case-steps]').forEach((stepper) => {
  const buttons = [...stepper.querySelectorAll('[data-case-step]')];
  const panels = [...stepper.querySelectorAll('[data-case-panel]')];

  if (!buttons.length || !panels.length) return;

  const activate = (target) => {
    buttons.forEach((button) => {
      const isActive = button.dataset.caseStep === target;
      button.classList.toggle('is-active', isActive);
      button.setAttribute('aria-selected', String(isActive));
    });

    panels.forEach((panel) => {
      panel.classList.toggle('is-active', panel.dataset.casePanel === target);
    });
  };

  buttons.forEach((button) => {
    button.addEventListener('click', () => activate(button.dataset.caseStep || '0'));
  });
});

const scrollVideoBlocks = [...document.querySelectorAll('[data-scroll-video]')];

const runWhenIdle = (callback, timeout = 1200) => {
  if ('requestIdleCallback' in window) {
    window.requestIdleCallback(callback, { timeout });
    return;
  }

  window.setTimeout(callback, Math.min(timeout, 900));
};

document.querySelectorAll('video[data-fg-lazy-video]').forEach((video) => {
  const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const smallViewport = window.matchMedia('(max-width: 860px)').matches;
  const constrainedConnection = Boolean(
    connection?.saveData ||
    ['slow-2g', '2g', '3g'].includes(connection?.effectiveType || '')
  );
  const interactionOnly = video.dataset.fgVideoSlowMode === 'interaction' &&
    (smallViewport || constrainedConnection || prefersReducedMotion);

  const loadVideo = () => {
    if (video.dataset.loaded === 'true') return;

    video.querySelectorAll('source[data-src]').forEach((source) => {
      source.src = source.dataset.src;
      source.removeAttribute('data-src');
    });
    video.dataset.loaded = 'true';
    video.load();
    video.play?.().catch(() => {});
  };

  if (interactionOnly) {
    const loadOnInteraction = () => loadVideo();
    ['pointerdown', 'keydown', 'touchstart'].forEach((eventName) => {
      window.addEventListener(eventName, loadOnInteraction, { once: true, passive: true });
    });
    return;
  }

  window.addEventListener('load', () => runWhenIdle(loadVideo, 1800), { once: true });
});

document.querySelectorAll('[data-fg-aw-story]').forEach((story) => {
  const canvas = story.querySelector('[data-fg-aw-story-canvas]');
  const panels = [...story.querySelectorAll('[data-fg-aw-story-panel]')];
  const progressBar = story.querySelector('[data-fg-aw-story-progress]');

  if (!canvas || !panels.length) return;

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const context = canvas.getContext('2d', { alpha: false, desynchronized: true });
  const frameCount = Number.parseInt(canvas.dataset.frameCount || '241', 10);
  const useMobileFrames = window.matchMedia('(max-width: 700px)').matches;
  const firstFrameUrl = useMobileFrames ? canvas.dataset.mobileFrame : canvas.dataset.desktopFrame;
  const frames = new Array(frameCount);
  let desiredFrame = 0;
  let renderedFrame = -1;
  let drawQueued = false;
  let activePanel = 0;

  if (!context || !firstFrameUrl) return;

  const frameUrl = (index) => firstFrameUrl.replace(
    /frame-001\.webp(?:\?.*)?$/,
    `frame-${String(index + 1).padStart(3, '0')}.webp${firstFrameUrl.includes('?') ? `?${firstFrameUrl.split('?')[1]}` : ''}`,
  );

  const activatePanel = (nextPanel) => {
    if (nextPanel === activePanel) return;

    activePanel = nextPanel;
    panels.forEach((panel, index) => {
      const isActive = index === activePanel;
      panel.classList.toggle('is-active', isActive);
      panel.setAttribute('aria-hidden', String(!isActive));
    });
  };

  const sizeCanvas = (image) => {
    const ratio = Math.min(window.devicePixelRatio || 1, 1.5);
    const width = Math.max(1, Math.round(canvas.clientWidth * ratio));
    const height = Math.max(1, Math.round(canvas.clientHeight * ratio));

    if (canvas.width !== width || canvas.height !== height) {
      canvas.width = width;
      canvas.height = height;
    }

    const coverScale = Math.max(width / image.naturalWidth, height / image.naturalHeight);
    const drawWidth = image.naturalWidth * coverScale;
    const drawHeight = image.naturalHeight * coverScale;
    const mobileHorizontalOffset = window.matchMedia('(max-width: 860px)').matches ? width * -0.05 : 0;
    context.drawImage(image, ((width - drawWidth) / 2) + mobileHorizontalOffset, (height - drawHeight) / 2, drawWidth, drawHeight);
  };

  const draw = () => {
    drawQueued = false;
    let frameToDraw = desiredFrame;
    let image = frames[frameToDraw];

    if (!image?.complete || !image.naturalWidth) {
      for (let distance = 1; distance <= 12; distance += 1) {
        const lowerFrame = Math.max(0, desiredFrame - distance);
        const upperFrame = Math.min(frameCount - 1, desiredFrame + distance);
        const lowerImage = frames[lowerFrame];
        const upperImage = frames[upperFrame];

        if (lowerImage?.complete && lowerImage.naturalWidth) {
          frameToDraw = lowerFrame;
          image = lowerImage;
          break;
        }

        if (upperImage?.complete && upperImage.naturalWidth) {
          frameToDraw = upperFrame;
          image = upperImage;
          break;
        }
      }
    }

    if (!image?.complete || !image.naturalWidth || renderedFrame === frameToDraw) return;

    sizeCanvas(image);
    renderedFrame = frameToDraw;
  };

  const queueDraw = () => {
    if (!drawQueued) {
      drawQueued = true;
      requestAnimationFrame(draw);
    }
  };

  const loadFrame = (index, priority = false) => {
    if (frames[index]) return;

    const image = new Image();
    image.decoding = 'async';
    image.src = frameUrl(index);
    if (priority) image.fetchPriority = 'high';
    image.onload = () => {
      if (index === desiredFrame || renderedFrame < 0) queueDraw();
    };
    frames[index] = image;
  };

  const preloadFrames = () => {
    loadFrame(0, true);

    // Load an evenly-spaced skeleton first so rapid scrolling always has a nearby frame.
    if (story.getBoundingClientRect().top < window.innerHeight * 1.2) {
      for (let index = 24; index < frameCount; index += 24) loadFrame(index);
    }
  };

  const handleScroll = () => {
    const rect = story.getBoundingClientRect();
    const scrollable = Math.max(1, rect.height - window.innerHeight);
    const progress = reduceMotion ? 0 : clamp(-rect.top / scrollable);

    desiredFrame = Math.min(frameCount - 1, Math.round(progress * (frameCount - 1)));
    activatePanel(Math.min(panels.length - 1, Math.floor(progress * panels.length)));
    if (progressBar) progressBar.style.transform = `scaleX(${progress})`;

    for (let distance = 0; distance <= 14; distance += 1) {
      loadFrame(Math.min(frameCount - 1, desiredFrame + distance), distance < 3);
      if (distance > 0) loadFrame(Math.max(0, desiredFrame - distance), distance < 3);
    }
    queueDraw();
  };

  preloadFrames();
  window.addEventListener('scroll', handleScroll, { passive: true });
  window.addEventListener('resize', () => {
    renderedFrame = -1;
    handleScroll();
  });
  handleScroll();
});

scrollVideoBlocks.forEach((block) => {
  const video = block.querySelector('video');
  if (!video) return;

  let duration = 0;
  let targetTime = 0;
  let currentTime = 0;
  let ticking = false;

  const calculate = () => {
    if (!duration) return;

    const rect = block.getBoundingClientRect();
    const scrollable = Math.max(1, rect.height - window.innerHeight);
    const progress = Math.min(1, Math.max(0, -rect.top / scrollable));
    targetTime = progress >= 0.995 ? duration : progress * duration;

    if (!ticking) {
      ticking = true;
      requestAnimationFrame(update);
    }
  };

  const update = () => {
    const edgeFrame = targetTime === 0 || targetTime === duration;
    currentTime += (targetTime - currentTime) * (edgeFrame ? 0.45 : 0.22);
    if (edgeFrame || Math.abs(targetTime - currentTime) < 0.015) {
      currentTime = targetTime;
      ticking = false;
    } else {
      requestAnimationFrame(update);
    }

    try {
      video.currentTime = Math.min(duration, Math.max(0, currentTime));
    } catch (_error) {
      ticking = false;
    }
  };

  const init = () => {
    duration = video.duration || 0;
    video.pause();
    calculate();
  };

  if (video.readyState >= 1) {
    init();
  } else {
    video.addEventListener('loadedmetadata', init, { once: true });
  }

  window.addEventListener('scroll', calculate, { passive: true });
  window.addEventListener('resize', calculate);
});

document.querySelectorAll('[data-fg-product-video-final]').forEach((finalVideo) => {
  const startSlot = document.querySelector('[data-fg-product-video-start]');
  const targetSlot = finalVideo.closest('.fg-product-why__media');
  const source = finalVideo.currentSrc || finalVideo.querySelector('source')?.src || finalVideo.getAttribute('src');

  if (
    !startSlot ||
    !targetSlot ||
    !source ||
    window.matchMedia('(prefers-reduced-motion: reduce)').matches
  ) {
    return;
  }

  finalVideo.muted = true;
  finalVideo.playsInline = true;
  finalVideo.preload = 'metadata';

  try {
    finalVideo.load();
  } catch (_error) {
    // Metadata loading is best-effort; the loadedmetadata handlers below retry setup.
  }

  let duration = 0;
  let scrollStart = 0;
  let scrollEnd = 1;
  let mobileScrollStart = 0;
  let mobileScrollEnd = 1;
  let ticking = false;

  const dockVideo = () => {
    if (finalVideo.parentElement !== targetSlot) {
      targetSlot.prepend(finalVideo);
    }

    finalVideo.classList.remove('fg-product-traveller-float', 'is-active');
    targetSlot.classList.add('is-product-video-docked');
    finalVideo.style.removeProperty('width');
    finalVideo.style.removeProperty('height');
    finalVideo.style.removeProperty('transform');
  };

  const floatVideo = () => {
    if (finalVideo.parentElement !== document.body) {
      document.body.appendChild(finalVideo);
    }

    targetSlot.classList.remove('is-product-video-docked');
    finalVideo.classList.add('fg-product-traveller-float', 'is-active');
  };

  const seekVideo = (time) => {
    if (!duration || Number.isNaN(time)) return;

    const nextTime = clamp(time, 0, Math.max(0, duration - 0.035));
    if (Math.abs(finalVideo.currentTime - nextTime) < 0.025) return;

    try {
      finalVideo.currentTime = nextTime;
    } catch (_error) {
      // Browsers can reject seeks before enough metadata is available.
    }
  };

  const measureTravel = () => {
    const scrollY = window.scrollY || window.pageYOffset || 0;
    const startRect = startSlot.getBoundingClientRect();
    const targetRect = targetSlot.getBoundingClientRect();
    const startDocTop = startRect.top + scrollY;
    const targetDocTop = targetRect.top + scrollY;

    scrollStart = Math.max(0, startDocTop - window.innerHeight * 0.18);
    scrollEnd = Math.max(scrollStart + 1, targetDocTop - Math.max(96, window.innerHeight * 0.16));
    mobileScrollStart = Math.max(0, targetDocTop - window.innerHeight * 0.82);
    mobileScrollEnd = mobileScrollStart + Math.max(1, window.innerHeight * 0.7);
  };

  const updateTravel = () => {
    ticking = false;

    if (!duration) return;

    const scrollY = window.scrollY || window.pageYOffset || 0;

    if (window.innerWidth <= 860) {
      dockVideo();
      const mobileProgress = clamp(
        (scrollY - mobileScrollStart) / Math.max(1, mobileScrollEnd - mobileScrollStart)
      );
      seekVideo(mobileProgress >= 0.995 ? duration : mobileProgress * duration);
      return;
    }

    const progress = clamp((scrollY - scrollStart) / Math.max(1, scrollEnd - scrollStart));
    const startRect = startSlot.getBoundingClientRect();
    const targetRect = targetSlot.getBoundingClientRect();
    const travelTime = progress * duration;

    seekVideo(progress >= 0.995 ? duration : travelTime);

    if (progress >= 0.995) {
      dockVideo();
      return;
    }

    floatVideo();

    const arc = Math.sin(progress * Math.PI) * -72;
    const x = startRect.left + (targetRect.left - startRect.left) * progress;
    const y = startRect.top + (targetRect.top - startRect.top) * progress + arc;
    const width = startRect.width + (targetRect.width - startRect.width) * progress;
    const height = startRect.height + (targetRect.height - startRect.height) * progress;

    finalVideo.style.width = `${Math.max(1, width)}px`;
    finalVideo.style.height = `${Math.max(1, height)}px`;
    finalVideo.style.transform = `translate3d(${x}px, ${y}px, 0)`;
  };

  const requestTravelUpdate = () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(updateTravel);
  };

  const initTravel = () => {
    duration = finalVideo.duration || 0;
    if (!duration) return;

    finalVideo.pause();
    seekVideo(0.001);
    measureTravel();
    window.setTimeout(() => {
      seekVideo(0);
      updateTravel();
    }, 80);
  };

  if (finalVideo.readyState >= 1) {
    initTravel();
  } else {
    finalVideo.addEventListener('loadedmetadata', initTravel, { once: true });
  }

  window.addEventListener('scroll', requestTravelUpdate, { passive: true });
  window.addEventListener('resize', () => {
    measureTravel();
    requestTravelUpdate();
  });
  window.addEventListener('load', () => {
    measureTravel();
    requestTravelUpdate();
  });
});

const loadQuoteFrame = (frameWrap) => {
  const quoteIframe = frameWrap?.querySelector('iframe[data-quote-iframe-src]');
  const quoteSrc = quoteIframe?.getAttribute('data-quote-iframe-src');

  if (!quoteIframe || !quoteSrc || quoteIframe.getAttribute('src')) {
    return;
  }

  const trackedQuoteSrc = windowCadUrlWithReference(quoteSrc);
  quoteIframe.setAttribute('data-quote-iframe-src', trackedQuoteSrc);
  quoteIframe.setAttribute('src', trackedQuoteSrc);
  frameWrap.setAttribute('data-quote-url', windowCadUrlWithReference(frameWrap.getAttribute('data-quote-url') || quoteSrc));
  trackWebsiteEvent('quote_iframe_loaded', {
    cta: 'Embedded instant quote',
    product_collection: new URL(trackedQuoteSrc).searchParams.get('productCollection') || '',
  });
  frameWrap.classList.add('is-loaded');
};

const scheduleQuoteFrameLoad = (frameWrap, delay = 0) => {
  if (!frameWrap || frameWrap.dataset.quoteLoadScheduled === 'true') return;

  frameWrap.dataset.quoteLoadScheduled = 'true';
  const load = () => loadQuoteFrame(frameWrap);

  if (delay > 0) {
    window.setTimeout(() => runWhenIdle(load, 1600), delay);
    return;
  }

  runWhenIdle(load, 1400);
};

const quoteAutoloadFrames = [...document.querySelectorAll('[data-quote-frame-wrap][data-quote-autoload]')];

if ('IntersectionObserver' in window) {
  const quoteFrameObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;

      scheduleQuoteFrameLoad(entry.target);
      quoteFrameObserver.unobserve(entry.target);
    });
  }, {
    rootMargin: '280px 0px',
    threshold: 0.01,
  });

  quoteAutoloadFrames.forEach((frameWrap) => {
    if (frameWrap.dataset.quoteAutoload === 'idle') {
      scheduleQuoteFrameLoad(frameWrap, 900);
      return;
    }

    quoteFrameObserver.observe(frameWrap);
  });
} else {
  quoteAutoloadFrames.forEach((frameWrap) => {
    scheduleQuoteFrameLoad(frameWrap, frameWrap.dataset.quoteAutoload === 'idle' ? 900 : 0);
  });
}

const quoteTouchQuery = window.matchMedia('(max-width: 860px)');
let quoteTouchLockTimer = 0;
let quoteTouchScrollY = 0;

const unlockQuotePageScroll = () => {
  if (!document.documentElement.classList.contains('fg-quote-touch-lock')) return;

  document.documentElement.classList.remove('fg-quote-touch-lock');
  document.body.style.removeProperty('position');
  document.body.style.removeProperty('top');
  document.body.style.removeProperty('left');
  document.body.style.removeProperty('right');
  document.body.style.removeProperty('width');
  window.scrollTo(0, quoteTouchScrollY);
  window.fensterLenis?.start?.();
};

const lockQuotePageScroll = () => {
  if (!quoteTouchQuery.matches) return;

  window.clearTimeout(quoteTouchLockTimer);
  quoteTouchScrollY = window.scrollY || window.pageYOffset || 0;

  if (!document.documentElement.classList.contains('fg-quote-touch-lock')) {
    window.fensterLenis?.stop?.();
    document.documentElement.classList.add('fg-quote-touch-lock');
    document.body.style.position = 'fixed';
    document.body.style.top = `-${quoteTouchScrollY}px`;
    document.body.style.left = '0';
    document.body.style.right = '0';
    document.body.style.width = '100%';
  }

  quoteTouchLockTimer = window.setTimeout(unlockQuotePageScroll, 2400);
};

document.querySelectorAll('[data-quote-frame-wrap]').forEach((frameWrap) => {
  frameWrap.addEventListener('touchstart', lockQuotePageScroll, { passive: true });
  frameWrap.addEventListener('pointerdown', (event) => {
    if (event.pointerType === 'touch') {
      lockQuotePageScroll();
    }
  });
});

['touchend', 'touchcancel', 'pointerup', 'pointercancel'].forEach((eventName) => {
  window.addEventListener(eventName, () => {
    window.clearTimeout(quoteTouchLockTimer);
    quoteTouchLockTimer = window.setTimeout(unlockQuotePageScroll, 180);
  }, { passive: true });
});

quoteTouchQuery.addEventListener?.('change', () => {
  if (!quoteTouchQuery.matches) {
    unlockQuotePageScroll();
  }
});

document.querySelectorAll('[data-load-quote]').forEach((quoteLoadButton) => {
  quoteLoadButton.addEventListener('click', () => {
    const quoteCard = quoteLoadButton.closest('[data-quote-card]') || quoteLoadButton.closest('section') || document;
    const frameWrap = quoteCard.matches?.('[data-quote-frame-wrap]')
      ? quoteCard
      : quoteCard.querySelector('[data-quote-frame-wrap]');

    loadQuoteFrame(frameWrap);
  });
});

document.querySelectorAll('[data-fullscreen-quote]').forEach((quoteFullscreenButton) => {
  quoteFullscreenButton.addEventListener('click', async () => {
    const quoteCard = quoteFullscreenButton.closest('[data-quote-card]') || quoteFullscreenButton.closest('section') || document;
    const frameWrap = quoteCard.querySelector('[data-quote-frame-wrap]');
    const quoteUrl = frameWrap?.getAttribute('data-quote-url');

    loadQuoteFrame(frameWrap);

    try {
      if (frameWrap?.requestFullscreen) {
        await frameWrap.requestFullscreen();
        return;
      }
    } catch (_error) {
      // Fall through to opening the designer in a new tab.
    }

    if (quoteUrl) {
      window.open(quoteUrl, '_blank', 'noopener');
    }
  });
});

const pageGradientMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  ? null
  : {
      frame: 0,
    };

if (pageGradientMotion) {
  const rootStyle = document.documentElement.style;
  const mobileGradientQuery = window.matchMedia('(max-width: 860px)');
  const hasHomeGradient = Boolean(document.querySelector('.generated-page--home-lab'));

  const updatePageGradient = () => {
    pageGradientMotion.frame = 0;
    const scrollRange = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);
    const progress = clamp((window.scrollY || 0) / scrollRange);
    const waveA = Math.sin(progress * Math.PI * 2.4);
    const waveB = Math.cos(progress * Math.PI * 1.8);
    const waveC = Math.sin((progress * Math.PI * 2) + 1.4);
    const useMobileHomeGradient = hasHomeGradient && mobileGradientQuery.matches;
    const greenX = useMobileHomeGradient ? 8 + waveA * 2 + progress * 8 : 6 + waveA * 10 + progress * 34;
    const greenY = useMobileHomeGradient ? 8 + waveB * 3 + progress * 14 : 8 + waveB * 18 + progress * 58;
    const blueX = useMobileHomeGradient ? 98 + waveC * 2 - progress * 8 : 92 + waveC * 12 - progress * 42;
    const blueY = useMobileHomeGradient ? 46 + waveA * 3 + progress * 12 : 10 + waveA * 16 + progress * 52;
    const washX = useMobileHomeGradient ? 50 + waveB * 4 - progress * 3 : 50 + waveB * 14 - progress * 8;
    const washY = useMobileHomeGradient ? 52 + waveC * 4 + progress * 8 : 44 + waveC * 16 + progress * 34;
    const greenAlpha = useMobileHomeGradient ? 0.01 + ((waveC + 1) / 2) * 0.008 : 0.15 + ((waveC + 1) / 2) * 0.18 + progress * 0.08;
    const blueAlpha = useMobileHomeGradient ? 0.008 + ((waveB + 1) / 2) * 0.006 : 0.13 + ((waveB + 1) / 2) * 0.14 + (1 - progress) * 0.05;
    const washAlpha = useMobileHomeGradient ? 0.9 + ((waveA + 1) / 2) * 0.06 : 0.36 + ((waveA + 1) / 2) * 0.28;
    const greenSize = useMobileHomeGradient ? '8%' : '30%';
    const blueSize = useMobileHomeGradient ? '9%' : '34%';
    const washSize = useMobileHomeGradient ? '20%' : '42%';

    rootStyle.setProperty('--fg-gradient-green-x', `${greenX.toFixed(2)}%`);
    rootStyle.setProperty('--fg-gradient-green-y', `${greenY.toFixed(2)}%`);
    rootStyle.setProperty('--fg-gradient-blue-x', `${blueX.toFixed(2)}%`);
    rootStyle.setProperty('--fg-gradient-blue-y', `${blueY.toFixed(2)}%`);
    rootStyle.setProperty('--fg-gradient-wash-x', `${washX.toFixed(2)}%`);
    rootStyle.setProperty('--fg-gradient-wash-y', `${washY.toFixed(2)}%`);
    rootStyle.setProperty('--fg-gradient-green-alpha', greenAlpha.toFixed(3));
    rootStyle.setProperty('--fg-gradient-blue-alpha', blueAlpha.toFixed(3));
    rootStyle.setProperty('--fg-gradient-wash-alpha', washAlpha.toFixed(3));
    rootStyle.setProperty('--fg-gradient-green-size', greenSize);
    rootStyle.setProperty('--fg-gradient-blue-size', blueSize);
    rootStyle.setProperty('--fg-gradient-wash-size', washSize);
  };

  const requestPageGradientUpdate = () => {
    if (!pageGradientMotion.frame) {
      pageGradientMotion.frame = requestAnimationFrame(updatePageGradient);
    }
  };

  window.addEventListener('scroll', requestPageGradientUpdate, { passive: true });
  window.addEventListener('resize', requestPageGradientUpdate);
  requestPageGradientUpdate();
}

const depthItems = [...document.querySelectorAll('[data-fg-depth]')];

const updateDepthItems = () => {
  depthItems.forEach((item) => {
    const rect = item.getBoundingClientRect();
    const strength = Number(item.getAttribute('data-fg-depth') || 0.08);
    const centerDistance = (rect.top + rect.height / 2) - window.innerHeight / 2;
    const offset = clamp(-centerDistance / Math.max(1, window.innerHeight), -1, 1) * strength * 180;
    item.style.setProperty('--fg-parallax-y', `${offset.toFixed(2)}px`);
  });
};

if (depthItems.length) {
  window.addEventListener('scroll', updateDepthItems, { passive: true });
  window.addEventListener('resize', updateDepthItems);
  updateDepthItems();
}

document.querySelectorAll('.fg-mk-page').forEach((page) => {
  const revealItems = [...page.querySelectorAll('[data-fg-mk-reveal]')];
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!revealItems.length || reduceMotion || !('IntersectionObserver' in window)) {
    revealItems.forEach((item) => item.classList.add('is-visible'));
    return;
  }

  page.classList.add('fg-mk-motion-ready');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target);
    });
  }, {
    rootMargin: '0px 0px -12% 0px',
    threshold: 0.14,
  });

  revealItems.forEach((item) => observer.observe(item));
});

document.querySelectorAll('[data-fg-home-product-story]').forEach((story) => {
  const steps = [...story.querySelectorAll('[data-fg-home-product-step]')];
  const images = [...story.querySelectorAll('[data-fg-home-product-image]')];
  const progress = story.querySelector('[data-fg-home-product-progress]');
  const title = story.querySelector('[data-fg-home-product-title]');
  const copy = story.querySelector('[data-fg-home-product-copy]');
  const action = story.querySelector('[data-fg-home-product-action]');
  const stageLink = story.querySelector('[data-fg-home-product-link]');

  if (!steps.length || !images.length) return;

  let activeIndex = -1;
  let productStoryFrame = 0;
  let lastProductStoryScroll = window.scrollY || 0;

  const setActiveProduct = (nextIndex) => {
    const index = clamp(nextIndex, 0, steps.length - 1);
    if (index === activeIndex) return;
    activeIndex = index;

    steps.forEach((step, stepIndex) => {
      const isActive = stepIndex === index;
      step.classList.toggle('is-active', isActive);
      if (isActive) {
        step.setAttribute('aria-current', 'true');
      } else {
        step.removeAttribute('aria-current');
      }
    });

    images.forEach((image, imageIndex) => {
      image.classList.toggle('is-active', imageIndex === index);
    });

    if (progress) {
      progress.style.transform = `scaleX(${((index + 1) / steps.length).toFixed(4)})`;
    }

    const activeTitle = steps[index].querySelector('strong')?.textContent?.trim() || '';
    if (title) {
      title.textContent = activeTitle;
    }

    if (copy) {
      copy.textContent = steps[index].getAttribute('data-product-copy') || '';
    }

    if (action) {
      action.textContent = activeTitle ? `View ${activeTitle}` : 'View product';
    }

    if (stageLink) {
      stageLink.setAttribute('href', steps[index].getAttribute('href') || '#');
      stageLink.setAttribute('aria-label', activeTitle ? `View ${activeTitle}` : 'View product');
    }
  };

  const calculateActiveProduct = () => {
    productStoryFrame = 0;
    if (window.innerWidth <= 860) return;

    const currentScroll = window.scrollY || 0;
    const scrollingDown = currentScroll >= lastProductStoryScroll;
    const downTrigger = window.innerHeight * 0.28;
    const upTrigger = window.innerHeight * 0.48;
    let nextIndex = Math.max(0, activeIndex);

    if (scrollingDown) {
      while (
        nextIndex < steps.length - 1
        && steps[nextIndex + 1].getBoundingClientRect().top <= downTrigger
      ) {
        nextIndex += 1;
      }
    } else {
      while (
        nextIndex > 0
        && steps[nextIndex].getBoundingClientRect().top >= upTrigger
      ) {
        nextIndex -= 1;
      }
    }

    lastProductStoryScroll = currentScroll;
    setActiveProduct(nextIndex);
  };

  const requestProductStoryUpdate = () => {
    if (productStoryFrame) return;
    productStoryFrame = requestAnimationFrame(calculateActiveProduct);
  };

  steps.forEach((step, index) => {
    step.addEventListener('pointerenter', () => setActiveProduct(index));
    step.addEventListener('focus', () => setActiveProduct(index));
  });

  window.addEventListener('scroll', requestProductStoryUpdate, { passive: true });
  window.addEventListener('resize', requestProductStoryUpdate);
  setActiveProduct(0);
  calculateActiveProduct();
});

document.querySelectorAll('[data-fg-product-theatre]').forEach((theatre) => {
  const stage = theatre.querySelector('.fg-home-product-theatre__stage');
  const shell = theatre.querySelector('.fg-home-product-theatre__shell');
  const frame = theatre.querySelector('[data-fg-product-tilt]');
  const visuals = [...theatre.querySelectorAll('[data-fg-product-visual]')];
  const contents = [...theatre.querySelectorAll('[data-fg-product-content]')];
  const navButtons = [...theatre.querySelectorAll('[data-fg-product-jump]')];
  const progressBar = theatre.querySelector('[data-fg-product-progress]');
  const counter = theatre.querySelector('[data-fg-product-counter]');
  const stageLink = theatre.querySelector('[data-fg-product-stage-link]');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const isStaticTheatre = theatre.dataset.fgProductTheatreMode === 'static';

  if (!stage || !visuals.length || !contents.length) return;

  const count = Math.min(visuals.length, contents.length);
  let activeIndex = -1;
  let targetProgress = 0;
  let renderedProgress = 0;
  let animationFrame = 0;
  let lastScrollY = window.scrollY || 0;
  let scrollDirection = 'down';

  const pad = (value) => String(value).padStart(2, '0');
  const setActiveScene = (nextIndex, source = 'scroll') => {
    const index = clamp(nextIndex, 0, count - 1);
    if (index === activeIndex) return;

    const previousIndex = activeIndex;
    activeIndex = index;
    theatre.dataset.activeProduct = String(index);
    theatre.dataset.direction = previousIndex < index ? 'forward' : 'backward';

    visuals.forEach((visual, visualIndex) => {
      const isActive = visualIndex === index;
      visual.classList.toggle('is-active', isActive);
      visual.classList.toggle('is-before', visualIndex < index);
      visual.classList.toggle('is-after', visualIndex > index);
      visual.setAttribute('aria-hidden', isActive ? 'false' : 'true');
    });

    contents.forEach((content, contentIndex) => {
      const isActive = contentIndex === index;
      content.classList.toggle('is-active', isActive);
      content.setAttribute('aria-hidden', isActive ? 'false' : 'true');
    });

    navButtons.forEach((button, buttonIndex) => {
      const isActive = buttonIndex === index;
      button.classList.toggle('is-active', isActive);
      button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
      if (isActive && source === 'keyboard') {
        button.focus({ preventScroll: true });
      }
    });

    if (counter) {
      counter.textContent = `${pad(index + 1)} / ${pad(count)}`;
    }

    if (stageLink) {
      const activeAction = contents[index]?.querySelector('a');
      const activeTitle = contents[index]?.querySelector('h3')?.textContent?.trim() || 'product';
      if (activeAction?.href) {
        stageLink.href = activeAction.href;
      }
      stageLink.setAttribute('aria-label', `Explore ${activeTitle}`);
    }

  };

  const readTheatreProgress = () => {
    const rect = theatre.getBoundingClientRect();
    const scrollable = Math.max(1, theatre.offsetHeight - window.innerHeight);
    return clamp(-rect.top / scrollable);
  };

  const updateFromScroll = () => {
    const currentScrollY = window.scrollY || 0;
    scrollDirection = currentScrollY >= lastScrollY ? 'down' : 'up';
    lastScrollY = currentScrollY;

    targetProgress = readTheatreProgress();
    const sceneFloat = targetProgress * count;
    const sceneIndex = Math.min(count - 1, Math.floor(sceneFloat));
    const localProgress = sceneFloat - sceneIndex;

    theatre.style.setProperty('--fg-theatre-local', localProgress.toFixed(4));
    theatre.style.setProperty('--fg-theatre-scene', String(sceneIndex));
    theatre.dataset.scrollDirection = scrollDirection;
    setActiveScene(sceneIndex);
  };

  const renderTheatre = () => {
    animationFrame = 0;
    const progressEase = reduceMotion.matches ? 1 : 0.22;

    renderedProgress += (targetProgress - renderedProgress) * progressEase;

    if (progressBar) {
      progressBar.style.transform = `scaleX(${renderedProgress.toFixed(5)})`;
    }

    if (Math.abs(targetProgress - renderedProgress) > 0.002) {
      animationFrame = requestAnimationFrame(renderTheatre);
    }
  };

  const requestRender = () => {
    if (!animationFrame) {
      animationFrame = requestAnimationFrame(renderTheatre);
    }
  };

  const syncScroll = () => {
    if (isStaticTheatre) return;
    if (window.innerWidth <= 860) return;
    updateFromScroll();
    requestRender();
  };

  const jumpToScene = (index, behavior = 'smooth') => {
    if (isStaticTheatre) {
      const nextIndex = clamp(index, 0, count - 1);
      setActiveScene(nextIndex, behavior === 'keyboard' ? 'keyboard' : 'click');
      targetProgress = count <= 1 ? 1 : (nextIndex + 1) / count;
      requestRender();
      return;
    }

    const scrollable = Math.max(1, theatre.offsetHeight - window.innerHeight);
    const sceneProgress = (clamp(index, 0, count - 1) + 0.16) / count;
    const theatreTop = theatre.getBoundingClientRect().top + (window.scrollY || 0);
    window.scrollTo({
      top: theatreTop + (scrollable * sceneProgress),
      behavior: reduceMotion.matches ? 'auto' : behavior,
    });
  };

  navButtons.forEach((button, index) => {
    button.setAttribute('aria-pressed', index === 0 ? 'true' : 'false');
    button.addEventListener('click', () => jumpToScene(index));
    button.addEventListener('keydown', (event) => {
      if (!['ArrowDown', 'ArrowUp', 'Home', 'End'].includes(event.key)) return;
      event.preventDefault();
      let nextIndex = index;
      if (event.key === 'ArrowDown') nextIndex = Math.min(count - 1, index + 1);
      if (event.key === 'ArrowUp') nextIndex = Math.max(0, index - 1);
      if (event.key === 'Home') nextIndex = 0;
      if (event.key === 'End') nextIndex = count - 1;
      setActiveScene(nextIndex, 'keyboard');
      jumpToScene(nextIndex, 'keyboard');
    });
  });

  const resetForViewport = () => {
    if (isStaticTheatre) {
      requestRender();
      return;
    }
    if (window.innerWidth <= 860) {
      return;
    }
    syncScroll();
  };

  window.addEventListener('scroll', syncScroll, { passive: true });
  window.addEventListener('resize', resetForViewport);
  reduceMotion.addEventListener?.('change', resetForViewport);

  setActiveScene(0);
  if (isStaticTheatre) {
    targetProgress = count <= 1 ? 1 : 1 / count;
    renderedProgress = targetProgress;
    if (progressBar) progressBar.style.transform = `scaleX(${renderedProgress.toFixed(5)})`;
  }
  resetForViewport();
  if (shell) {
    if (window.innerWidth <= 860) {
      shell.classList.add('is-ready');
      return;
    }

    const imageDecodes = visuals.map((image) => {
      if (image.complete && image.naturalWidth > 0) return Promise.resolve();
      return typeof image.decode === 'function'
        ? image.decode().catch(() => undefined)
        : new Promise((resolve) => {
            image.addEventListener('load', resolve, { once: true });
            image.addEventListener('error', resolve, { once: true });
          });
    });

    Promise.allSettled(imageDecodes).then(() => {
      shell.classList.add('is-ready');
    });
  }
});

document.querySelectorAll('.fg-home-product-theatre__mobile').forEach((mobileTheatre) => {
  const track = mobileTheatre.querySelector('.fg-home-product-theatre__mobile-track');
  const cards = [...mobileTheatre.querySelectorAll('.fg-home-product-theatre__mobile-card')];
  const dots = [...mobileTheatre.querySelectorAll('[data-fg-mobile-product-dot]')];
  const previousButton = mobileTheatre.querySelector('[data-fg-mobile-product-prev]');
  const nextButton = mobileTheatre.querySelector('[data-fg-mobile-product-next]');

  if (!track || !cards.length || dots.length !== cards.length) return;

  let activeIndex = 0;
  let scrollFrame = 0;

  const setActiveDot = (nextIndex) => {
    const index = clamp(nextIndex, 0, dots.length - 1);
    activeIndex = index;

    dots.forEach((dot, dotIndex) => {
      const isActive = dotIndex === index;
      dot.classList.toggle('is-active', isActive);
      dot.setAttribute('aria-current', isActive ? 'true' : 'false');
    });

    if (previousButton) previousButton.disabled = index === 0;
    if (nextButton) nextButton.disabled = index === cards.length - 1;
  };

  const updateActiveDot = () => {
    scrollFrame = 0;
    const trackLeft = track.getBoundingClientRect().left;
    let nearestIndex = 0;
    let nearestDistance = Number.POSITIVE_INFINITY;

    cards.forEach((card, index) => {
      const distance = Math.abs(card.getBoundingClientRect().left - trackLeft);
      if (distance < nearestDistance) {
        nearestDistance = distance;
        nearestIndex = index;
      }
    });

    if (nearestIndex !== activeIndex) setActiveDot(nearestIndex);
  };

  track.addEventListener('scroll', () => {
    if (!scrollFrame) scrollFrame = requestAnimationFrame(updateActiveDot);
  }, { passive: true });

  const scrollToCard = (nextIndex) => {
    const index = clamp(nextIndex, 0, cards.length - 1);
    const trackLeft = track.getBoundingClientRect().left;
    const cardLeft = cards[index].getBoundingClientRect().left;

    track.scrollTo({
      left: track.scrollLeft + cardLeft - trackLeft,
      behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
    });
    setActiveDot(index);
  };

  previousButton?.addEventListener('click', () => scrollToCard(activeIndex - 1));
  nextButton?.addEventListener('click', () => scrollToCard(activeIndex + 1));
  window.addEventListener('resize', () => {
    if (!scrollFrame) scrollFrame = requestAnimationFrame(updateActiveDot);
  });

  setActiveDot(0);
});

document.querySelectorAll('.fg-home-case-wall').forEach((caseWall) => {
  const track = caseWall.querySelector('.fg-home-case-wall__grid');
  const cards = [...caseWall.querySelectorAll('.fg-home-case-card')];
  const dots = [...caseWall.querySelectorAll('[data-fg-case-dot]')];

  if (!track || !cards.length || dots.length !== cards.length) return;

  let activeIndex = 0;
  let scrollFrame = 0;

  const setActiveDot = (nextIndex) => {
    const index = clamp(nextIndex, 0, dots.length - 1);
    activeIndex = index;
    dots.forEach((dot, dotIndex) => {
      const isActive = dotIndex === index;
      dot.classList.toggle('is-active', isActive);
      dot.setAttribute('aria-current', isActive ? 'true' : 'false');
    });
  };

  const updateActiveDot = () => {
    scrollFrame = 0;
    const trackLeft = track.getBoundingClientRect().left;
    let nearestIndex = 0;
    let nearestDistance = Number.POSITIVE_INFINITY;

    cards.forEach((card, index) => {
      const distance = Math.abs(card.getBoundingClientRect().left - trackLeft);
      if (distance < nearestDistance) {
        nearestDistance = distance;
        nearestIndex = index;
      }
    });

    if (nearestIndex !== activeIndex) setActiveDot(nearestIndex);
  };

  track.addEventListener('scroll', () => {
    if (window.innerWidth > 860) return;
    if (!scrollFrame) scrollFrame = requestAnimationFrame(updateActiveDot);
  }, { passive: true });

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      const trackLeft = track.getBoundingClientRect().left;
      const cardLeft = cards[index].getBoundingClientRect().left;
      track.scrollTo({
        left: track.scrollLeft + cardLeft - trackLeft,
        behavior: 'smooth',
      });
      setActiveDot(index);
    });
  });

  setActiveDot(0);
});

document.querySelectorAll('[data-fg-review-carousel]').forEach((carousel) => {
  const track = carousel.querySelector('[data-fg-review-track]');
  const cards = [...carousel.querySelectorAll('.fg-review-showcase__card')];
  const prevButton = carousel.querySelector('[data-fg-review-prev]');
  const nextButton = carousel.querySelector('[data-fg-review-next]');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!track || cards.length < 2 || !prevButton || !nextButton) return;

  let activeIndex = 0;
  let scrollFrame = 0;
  let autoTimer = 0;
  let isPaused = false;

  const getNearestIndex = () => {
    const trackLeft = track.getBoundingClientRect().left;
    let nearestIndex = 0;
    let nearestDistance = Number.POSITIVE_INFINITY;

    cards.forEach((card, index) => {
      const distance = Math.abs(card.getBoundingClientRect().left - trackLeft);
      if (distance < nearestDistance) {
        nearestDistance = distance;
        nearestIndex = index;
      }
    });

    return nearestIndex;
  };

  const syncButtons = () => {
    const maxScroll = track.scrollWidth - track.clientWidth - 2;
    prevButton.disabled = track.scrollLeft <= 2;
    nextButton.disabled = track.scrollLeft >= maxScroll;
  };

  const scrollToIndex = (nextIndex, behavior = 'smooth') => {
    const index = clamp(nextIndex, 0, cards.length - 1);
    const trackLeft = track.getBoundingClientRect().left;
    const cardLeft = cards[index].getBoundingClientRect().left;

    activeIndex = index;
    track.scrollTo({
      left: track.scrollLeft + cardLeft - trackLeft,
      behavior,
    });
  };

  const updateFromScroll = () => {
    scrollFrame = 0;
    activeIndex = getNearestIndex();
    syncButtons();
  };

  const stopAuto = () => {
    if (!autoTimer) return;
    window.clearInterval(autoTimer);
    autoTimer = 0;
  };

  const startAuto = () => {
    if (reduceMotion || autoTimer || cards.length < 2) return;
    autoTimer = window.setInterval(() => {
      if (isPaused) return;
      const atEnd = track.scrollLeft >= track.scrollWidth - track.clientWidth - 2;
      scrollToIndex(atEnd ? 0 : activeIndex + 1);
    }, 4200);
  };

  track.addEventListener('scroll', () => {
    if (!scrollFrame) scrollFrame = requestAnimationFrame(updateFromScroll);
  }, { passive: true });

  prevButton.addEventListener('click', () => {
    stopAuto();
    scrollToIndex(getNearestIndex() - 1);
    startAuto();
  });

  nextButton.addEventListener('click', () => {
    stopAuto();
    scrollToIndex(getNearestIndex() + 1);
    startAuto();
  });

  ['pointerenter', 'focusin', 'touchstart'].forEach((eventName) => {
    carousel.addEventListener(eventName, () => {
      isPaused = true;
    }, { passive: true });
  });

  ['pointerleave', 'focusout'].forEach((eventName) => {
    carousel.addEventListener(eventName, () => {
      isPaused = false;
    });
  });

  carousel.addEventListener('touchend', () => {
    window.setTimeout(() => {
      isPaused = false;
    }, 1800);
  }, { passive: true });

  window.addEventListener('resize', syncButtons);
  syncButtons();
  startAuto();
});

document.querySelectorAll('[data-fg-product-intel]').forEach((explorer) => {
  const tabs = [...explorer.querySelectorAll('[data-fg-product-intel-tab]')];
  const panels = [...explorer.querySelectorAll('[data-fg-product-intel-panel]')];

  if (!tabs.length || !panels.length) return;

  const activate = (nextIndex, focus = false) => {
    const index = Math.max(0, Math.min(tabs.length - 1, nextIndex));

    tabs.forEach((tab, tabIndex) => {
      const active = tabIndex === index;
      tab.classList.toggle('is-active', active);
      tab.setAttribute('aria-selected', active ? 'true' : 'false');
      tab.tabIndex = active ? 0 : -1;
      if (active && focus) tab.focus();
    });

    panels.forEach((panel, panelIndex) => {
      const active = panelIndex === index;
      panel.classList.toggle('is-active', active);
      panel.hidden = !active;
    });
  };

  tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => activate(index));
    tab.addEventListener('keydown', (event) => {
      let next = index;

      if (event.key === 'ArrowRight' || event.key === 'ArrowDown') next = index + 1;
      if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') next = index - 1;
      if (event.key === 'Home') next = 0;
      if (event.key === 'End') next = tabs.length - 1;

      if (next !== index) {
        event.preventDefault();
        activate((next + tabs.length) % tabs.length, true);
      }
    });
  });
});

const galleryLightboxLinks = [...document.querySelectorAll('[data-fg-gallery-lightbox]')];

if (galleryLightboxLinks.length) {
  const lightbox = document.createElement('div');
  lightbox.className = 'fg-gallery-lightbox';
  lightbox.setAttribute('role', 'dialog');
  lightbox.setAttribute('aria-modal', 'true');
  lightbox.setAttribute('aria-label', 'Image preview');
  lightbox.hidden = true;
  lightbox.innerHTML = `
    <button class="fg-gallery-lightbox__close" type="button" aria-label="Close image preview">Close</button>
    <button class="fg-gallery-lightbox__arrow fg-gallery-lightbox__arrow--prev" type="button" aria-label="Previous image">‹</button>
    <figure class="fg-gallery-lightbox__figure">
      <img alt="">
    </figure>
    <button class="fg-gallery-lightbox__arrow fg-gallery-lightbox__arrow--next" type="button" aria-label="Next image">›</button>
  `;
  document.body.appendChild(lightbox);

  const lightboxImage = lightbox.querySelector('img');
  const closeButton = lightbox.querySelector('.fg-gallery-lightbox__close');
  const prevButton = lightbox.querySelector('.fg-gallery-lightbox__arrow--prev');
  const nextButton = lightbox.querySelector('.fg-gallery-lightbox__arrow--next');
  let previousFocus = null;
  let currentIndex = 0;

  const closeLightbox = () => {
    lightbox.hidden = true;
    document.documentElement.classList.remove('fg-gallery-lightbox-open');
    if (lightboxImage) {
      lightboxImage.removeAttribute('src');
    }
    previousFocus?.focus?.({ preventScroll: true });
  };

  const setLightboxImage = (index) => {
    currentIndex = (index + galleryLightboxLinks.length) % galleryLightboxLinks.length;
    const link = galleryLightboxLinks[currentIndex];
    const image = link.querySelector('img');
    const src = link.getAttribute('href');
    const alt = image?.getAttribute('alt') || 'Product gallery image';

    if (!src || !lightboxImage) return;

    lightboxImage.src = src;
    lightboxImage.alt = alt;
  };

  const openLightbox = (index) => {
    previousFocus = document.activeElement;
    setLightboxImage(index);
    lightbox.hidden = false;
    document.documentElement.classList.add('fg-gallery-lightbox-open');
    closeButton?.focus?.({ preventScroll: true });
  };

  const moveLightbox = (direction) => {
    if (lightbox.hidden) return;
    setLightboxImage(currentIndex + direction);
  };

  galleryLightboxLinks.forEach((link, index) => {
    link.addEventListener('click', (event) => {
      event.preventDefault();
      openLightbox(index);
    });
  });

  closeButton?.addEventListener('click', closeLightbox);
  prevButton?.addEventListener('click', () => moveLightbox(-1));
  nextButton?.addEventListener('click', () => moveLightbox(1));
  lightbox.addEventListener('click', (event) => {
    if (event.target === lightbox) {
      closeLightbox();
    }
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !lightbox.hidden) {
      closeLightbox();
    }
    if (event.key === 'ArrowLeft') {
      moveLightbox(-1);
    }
    if (event.key === 'ArrowRight') {
      moveLightbox(1);
    }
  });
}

document.querySelectorAll('[data-fg-window-selector]').forEach((selector) => {
  const options = [...selector.querySelectorAll('[data-fg-window-option]')];
  const images = [...selector.querySelectorAll('[data-fg-window-image]')];
  const details = [...selector.querySelectorAll('[data-fg-window-detail]')];
  const preview = selector.querySelector('[data-fg-window-preview]');

  if (!options.length || !images.length || !details.length || !preview) return;

  let activeIndex = -1;

  const activateWindow = (nextIndex) => {
    const index = clamp(nextIndex, 0, options.length - 1);
    if (index === activeIndex) return;
    activeIndex = index;

    options.forEach((option, optionIndex) => {
      const active = optionIndex === index;
      option.classList.toggle('is-active', active);
      option.setAttribute('aria-selected', active ? 'true' : 'false');
      option.tabIndex = active ? 0 : -1;
    });

    images.forEach((image, imageIndex) => {
      image.classList.toggle('is-active', imageIndex === index);
    });

    details.forEach((detail, detailIndex) => {
      const active = detailIndex === index;
      detail.classList.toggle('is-active', active);
      detail.setAttribute('aria-hidden', active ? 'false' : 'true');
    });

    const activeLink = details[index]?.querySelector('strong')?.textContent?.trim() || 'window';
    const destination = options[index].getAttribute('data-window-url');
    if (destination) preview.href = destination;
    preview.setAttribute('aria-label', activeLink);
  };

  options.forEach((option, index) => {
    option.addEventListener('pointerenter', () => activateWindow(index));
    option.addEventListener('focus', () => activateWindow(index));
    option.addEventListener('click', () => {
      const destination = option.getAttribute('data-window-url');
      if (destination) window.location.href = destination;
    });
    option.addEventListener('keydown', (event) => {
      if (!['ArrowDown', 'ArrowUp', 'Home', 'End'].includes(event.key)) return;
      event.preventDefault();
      let next = index;
      if (event.key === 'ArrowDown') next = Math.min(options.length - 1, index + 1);
      if (event.key === 'ArrowUp') next = Math.max(0, index - 1);
      if (event.key === 'Home') next = 0;
      if (event.key === 'End') next = options.length - 1;
      activateWindow(next);
      options[next].focus();
    });
  });

  const decodeImages = images.map((image) => (
    typeof image.decode === 'function' ? image.decode().catch(() => undefined) : Promise.resolve()
  ));

  Promise.allSettled(decodeImages).then(() => selector.classList.add('is-ready'));
  activateWindow(0);
});

if (false) {
  // ---------------------------------------------------------------------------
  // Fenster "systems studio" — one cohesive modern house that the camera tours.
  // As the page scrolls the camera orbits the building and zooms into each real
  // product: aluminium windows, a folding bifold set, the composite front door,
  // the roof lantern and the commercial curtain-wall wing. Every moving part is
  // hinged from a real pivot and every handle is parented to its own leaf, so
  // nothing floats and every element opens the way it should.
  // ---------------------------------------------------------------------------
  const scene = new THREE.Scene();
  scene.fog = new THREE.FogExp2(0x9fc4d4, 0.013);

  const camera = new THREE.PerspectiveCamera(36, 1, 0.1, 200);
  const renderer = new THREE.WebGLRenderer({
    canvas: studioCanvas,
    alpha: true,
    antialias: true,
    powerPreference: 'high-performance',
  });

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.05;

  const mats = {
    render: new THREE.MeshStandardMaterial({ color: 0xeef0ec, roughness: 0.92, metalness: 0.02 }),
    renderWarm: new THREE.MeshStandardMaterial({ color: 0xd9d2c4, roughness: 0.95, metalness: 0.0 }),
    brick: new THREE.MeshStandardMaterial({ color: 0x9a5640, roughness: 0.85, metalness: 0.02 }),
    brickDark: new THREE.MeshStandardMaterial({ color: 0x6f3b2c, roughness: 0.88, metalness: 0.02 }),
    anthracite: new THREE.MeshStandardMaterial({ color: 0x1c2024, roughness: 0.42, metalness: 0.55 }),
    frame: new THREE.MeshStandardMaterial({ color: 0x14171a, roughness: 0.35, metalness: 0.65 }),
    trim: new THREE.MeshStandardMaterial({ color: 0xf6f7f4, roughness: 0.55, metalness: 0.05 }),
    steel: new THREE.MeshStandardMaterial({ color: 0xc4ccd2, roughness: 0.28, metalness: 0.9 }),
    chrome: new THREE.MeshStandardMaterial({ color: 0xe6ebef, roughness: 0.16, metalness: 1.0 }),
    roof: new THREE.MeshStandardMaterial({ color: 0x2b2f33, roughness: 0.62, metalness: 0.18, side: THREE.DoubleSide }),
    door: new THREE.MeshStandardMaterial({ color: 0x16302b, roughness: 0.4, metalness: 0.22 }),
    accent: new THREE.MeshStandardMaterial({ color: 0x2eac66, roughness: 0.4, metalness: 0.3 }),
    ground: new THREE.MeshStandardMaterial({ color: 0x16323b, roughness: 0.96, metalness: 0.0 }),
    lawn: new THREE.MeshStandardMaterial({ color: 0x2c6b4f, roughness: 1.0, metalness: 0.0 }),
    path: new THREE.MeshStandardMaterial({ color: 0xb9bcb6, roughness: 0.9, metalness: 0.0 }),
    glass: new THREE.MeshPhysicalMaterial({
      color: 0x9fc7da,
      metalness: 0.2,
      roughness: 0.04,
      transmission: 0.0,
      transparent: true,
      opacity: 0.96,
      reflectivity: 1.0,
      clearcoat: 1,
      clearcoatRoughness: 0.02,
      emissive: 0x86c2e0,
      emissiveIntensity: 0.35,
    }),
    glassWarm: new THREE.MeshPhysicalMaterial({
      color: 0xffd9a0,
      metalness: 0,
      roughness: 0.18,
      transmission: 0.4,
      transparent: true,
      opacity: 0.78,
      emissive: 0xffb55c,
      emissiveIntensity: 0.55,
    }),
  };

  const root = new THREE.Group();
  scene.add(root);

  // Soft vertical sky gradient as the scene background so glass and metal have
  // something bright to reflect, and the studio reads as a clean daytime shot.
  const skyCanvas = document.createElement('canvas');
  skyCanvas.width = 8;
  skyCanvas.height = 256;
  const skyCtx = skyCanvas.getContext('2d');
  const skyGrad = skyCtx.createLinearGradient(0, 0, 0, 256);
  skyGrad.addColorStop(0, '#afe0f2');
  skyGrad.addColorStop(0.55, '#cfe9f2');
  skyGrad.addColorStop(1, '#eef6f4');
  skyCtx.fillStyle = skyGrad;
  skyCtx.fillRect(0, 0, 8, 256);
  const skyTexture = new THREE.CanvasTexture(skyCanvas);
  skyTexture.colorSpace = THREE.SRGBColorSpace;
  scene.background = skyTexture;
  scene.environment = skyTexture;

  // Reusable, shared box geometry keeps the build cheap; meshes scale it.
  const UNIT = new THREE.BoxGeometry(1, 1, 1);

  const box = (group, material, size, position, rotation = [0, 0, 0], cast = true) => {
    const mesh = new THREE.Mesh(UNIT, material);
    mesh.scale.set(size[0], size[1], size[2]);
    mesh.position.set(position[0], position[1], position[2]);
    mesh.rotation.set(rotation[0], rotation[1], rotation[2]);
    mesh.castShadow = cast;
    mesh.receiveShadow = true;
    group.add(mesh);
    return mesh;
  };

  // A reusable glazed leaf: aluminium frame + mullions + glass, origin on the
  // LEFT edge so the group can be used as a real hinge pivot.
  const makeGlazedLeaf = (width, height, depth = 0.08, { mullions = 1, glass = mats.glass } = {}) => {
    const leaf = new THREE.Group();
    const f = 0.05; // frame thickness
    box(leaf, mats.frame, [width, f, depth], [width / 2, height / 2 - f / 2, 0]);
    box(leaf, mats.frame, [width, f, depth], [width / 2, -height / 2 + f / 2, 0]);
    box(leaf, mats.frame, [f, height, depth], [f / 2, 0, 0]);
    box(leaf, mats.frame, [f, height, depth], [width - f / 2, 0, 0]);
    for (let i = 1; i <= mullions; i++) {
      const x = (width / (mullions + 1)) * i;
      box(leaf, mats.frame, [0.035, height - f * 2, depth * 0.9], [x, 0, 0]);
    }
    const pane = box(leaf, glass, [width - f * 2, height - f * 2, 0.02], [width / 2, 0, 0], [0, 0, 0], false);
    pane.castShadow = false;
    return leaf;
  };

  // A lever handle that is always parented to the leaf it controls.
  const addHandle = (parent, x, y, z, vertical = true) => {
    const handle = new THREE.Group();
    box(handle, mats.chrome, [0.045, vertical ? 0.42 : 0.045, 0.045], [0, 0, 0]);
    box(handle, mats.chrome, [0.05, 0.05, 0.09], [0, vertical ? 0.16 : 0, 0.06]);
    handle.position.set(x, y, z);
    parent.add(handle);
    return handle;
  };

  // ---- The house shell ------------------------------------------------------
  // Footprint is centred on the origin. +Z faces the camera at the start
  // (the entrance / window face). +X is the garden gable that holds the bifold.
  const HALF_W = 3.2; // half width  (x)
  const HALF_D = 2.4; // half depth  (z)
  const WALL_H = 3.0; // wall height
  const WALL_T = 0.18;

  const house = new THREE.Group();
  root.add(house);

  const makeShell = () => {
    const g = new THREE.Group();
    // Back wall (north, -Z) solid render.
    box(g, mats.render, [HALF_W * 2, WALL_H, WALL_T], [0, WALL_H / 2, -HALF_D]);
    // Left wall (west, -X) brick with a punched window opening handled visually.
    box(g, mats.brick, [WALL_T, WALL_H, HALF_D * 2], [-HALF_W, WALL_H / 2, 0]);
    box(g, mats.brickDark, [WALL_T * 1.04, 0.5, HALF_D * 2], [-HALF_W, 0.25, 0]);
    // Plinth / base course wrapping the whole house.
    box(g, mats.brickDark, [HALF_W * 2 + 0.12, 0.32, HALF_D * 2 + 0.12], [0, 0.16, 0]);
    // Floor slab inside.
    box(g, mats.render, [HALF_W * 2 - 0.1, 0.08, HALF_D * 2 - 0.1], [0, 0.34, 0], [0, 0, 0], false);
    return g;
  };
  house.add(makeShell());

  // Front (south, +Z) face: split into a brick base and a rendered upper band,
  // with openings left for the door and the picture window.
  const makeFrontFace = () => {
    const g = new THREE.Group();
    const z = HALF_D;
    // Pier between door (left) and window (right).
    box(g, mats.render, [0.7, WALL_H, WALL_T], [0.05, WALL_H / 2, z]);
    // Left return beside the door.
    box(g, mats.brick, [1.0, WALL_H, WALL_T], [-2.7, WALL_H / 2, z]);
    // Right return beyond the window.
    box(g, mats.brick, [0.5, WALL_H, WALL_T], [2.95, WALL_H / 2, z]);
    // Header above door + window.
    box(g, mats.render, [HALF_W * 2, 0.55, WALL_T + 0.02], [0, WALL_H - 0.27, z]);
    // Cill course under the window.
    box(g, mats.brick, [2.2, 0.9, WALL_T], [1.55, 0.55, z]);
    box(g, mats.trim, [2.35, 0.08, WALL_T + 0.08], [1.55, 1.02, z + 0.02]);
    return g;
  };
  house.add(makeFrontFace());

  // Pitched roof. The ridge runs along X, so the gables (triangular ends) face
  // -X (commercial wing side) and +X (garden / bifold side). Each slope plane
  // is sized so its low edge lands on the eave and its high edge on the ridge.
  const RIDGE_H = WALL_H + 1.25;
  const ROOF_OVER = 0.32; // eave overhang past the wall on the front/back
  const makeRoof = () => {
    const g = new THREE.Group();
    const rise = RIDGE_H - WALL_H;
    const run = HALF_D + ROOF_OVER;
    const depth = HALF_W * 2 + 0.36; // length along the ridge (X), incl. overhang

    // Build the whole roof as ONE solid triangular prism so it is watertight and
    // shades correctly. The gable triangle is drawn in the Z/Y plane (shape x = z,
    // shape y = height above the eave) and extruded along the ridge, then laid
    // down along X. This avoids any chance of slopes failing to meet the ridge.
    const profile = new THREE.Shape();
    profile.moveTo(-run, 0);
    profile.lineTo(run, 0);
    profile.lineTo(0, rise);
    profile.lineTo(-run, 0);
    const roofGeo = new THREE.ExtrudeGeometry(profile, { depth, bevelEnabled: false, steps: 1 });
    // Centre the extrusion on X and orient shape-x -> world Z, shape-y -> world Y.
    roofGeo.rotateY(-Math.PI / 2);
    roofGeo.translate(depth / 2, 0, 0); // recentre on X = 0 after rotation
    const shell = new THREE.Mesh(roofGeo, mats.roof);
    shell.position.set(0, WALL_H, 0);
    shell.castShadow = true;
    shell.receiveShadow = true;
    g.add(shell);

    // Ridge cap line.
    box(g, mats.frame, [depth, 0.12, 0.12], [0, RIDGE_H + 0.03, 0]);
    // Fascia boards along both eaves for a crisp modern edge.
    box(g, mats.trim, [depth, 0.16, 0.1], [0, WALL_H + 0.02, run], [0, 0, 0]);
    box(g, mats.trim, [depth, 0.16, 0.1], [0, WALL_H + 0.02, -run], [0, 0, 0]);

    g.userData.ridge = RIDGE_H;
    g.userData.angle = Math.atan2(rise, run);
    g.userData.run = run;
    return g;
  };
  const roof = makeRoof();
  house.add(roof);

  // ---- Assemblies (product focus points) -----------------------------------
  // Each assembly is positioned where it belongs on the house and exposes the
  // bits the animation loop drives (pivots / leaves). A `focus` Vector3 marks a
  // good place for the camera to look while that product is on stage.

  // 1. Aluminium picture windows on the front-right of the house.
  const makeWindows = () => {
    const g = new THREE.Group();
    const z = HALF_D + 0.02;
    const frameW = 2.1;
    const frameH = 1.7;
    box(g, mats.anthracite, [frameW + 0.12, frameH + 0.12, 0.14], [0, 0, 0]);
    box(g, mats.frame, [frameW, 0.05, 0.16], [0, frameH / 2 - 0.02, 0.01]);
    box(g, mats.frame, [frameW, 0.05, 0.16], [0, -frameH / 2 + 0.02, 0.01]);
    box(g, mats.frame, [0.05, frameH, 0.16], [0, 0, 0.01]);
    // Two glazed casements, the right one tilts open slightly.
    const left = makeGlazedLeaf(frameW / 2 - 0.04, frameH - 0.04, 0.06, { mullions: 0 });
    left.position.set(-frameW / 2 + 0.04, -(frameH - 0.04) / 2, 0.04);
    g.add(left);
    addHandle(left, frameW / 2 - 0.12, 0, 0.07);
    const rightPivot = new THREE.Group();
    const right = makeGlazedLeaf(frameW / 2 - 0.04, frameH - 0.04, 0.06, { mullions: 0 });
    right.position.set(0, -(frameH - 0.04) / 2, 0);
    rightPivot.add(right);
    addHandle(right, 0.12, 0, 0.07);
    rightPivot.position.set(0.04, 0, 0.04);
    g.add(rightPivot);
    g.position.set(1.55, 1.78, z);
    g.userData.tilt = rightPivot;
    g.userData.focus = new THREE.Vector3(1.55, 1.78, HALF_D);
    return g;
  };
  const windows = makeWindows();
  house.add(windows);

  // 2. Aluminium bifold doors on the garden gable (+X face), folding outward.
  const makeBifold = () => {
    const g = new THREE.Group();
    const panels = 4;
    const panelW = 0.82;
    const panelH = 2.5;
    const setW = panels * panelW;
    // Structural opening: head + cill track on the gable.
    box(g, mats.anthracite, [0.16, 0.1, setW + 0.1], [0, panelH + 0.05, 0]);
    box(g, mats.frame, [0.16, 0.08, setW + 0.1], [0, 0.04, 0]);
    box(g, mats.anthracite, [0.16, panelH + 0.2, 0.12], [0, panelH / 2, setW / 2 + 0.05]);
    const pivots = [];
    // Panels concertina in linked pairs. Even panels hinge on the head track,
    // odd panels hinge off the previous panel's leading edge.
    for (let i = 0; i < panels; i++) {
      const pivot = new THREE.Group();
      const leaf = makeGlazedLeaf(panelW - 0.02, panelH, 0.07, { mullions: 0 });
      // Leaf modelled in the X/Y plane then rotated to sit in the gable (Z run).
      leaf.rotation.y = -Math.PI / 2;
      leaf.position.set(0, -panelH / 2, 0);
      pivot.add(leaf);
      pivot.position.set(0, panelH / 2, setW / 2 - i * panelW);
      if (i === 0 || i === panels - 1) addHandle(leaf, 0, 0, 0.08);
      g.add(pivot);
      pivots.push(pivot);
    }
    g.position.set(HALF_W + 0.01, 0.34, 0);
    g.userData.pivots = pivots;
    g.userData.panelW = panelW;
    g.userData.focus = new THREE.Vector3(HALF_W + 0.6, 1.5, 0);
    return g;
  };
  const bifold = makeBifold();
  house.add(bifold);

  // 3. Composite front door on the left of the front face, on a real hinge.
  const makeDoor = () => {
    const g = new THREE.Group();
    const z = HALF_D + 0.04;
    const doorW = 0.98;
    const doorH = 2.32;
    // Frame / surround.
    box(g, mats.trim, [doorW + 0.22, doorH + 0.16, 0.16], [0, doorH / 2 + 0.04, 0]);
    box(g, mats.door, [doorW + 0.04, doorH + 0.02, 0.06], [0, doorH / 2 + 0.04, 0.06]);
    // Hinged leaf, hinge on the left edge.
    const hinge = new THREE.Group();
    const leaf = new THREE.Group();
    box(leaf, mats.door, [doorW, doorH, 0.1], [doorW / 2, doorH / 2, 0]);
    // Modern recessed panels.
    box(leaf, mats.anthracite, [doorW - 0.22, 0.05, 0.12], [doorW / 2, doorH * 0.7, 0.02]);
    box(leaf, mats.anthracite, [doorW - 0.22, 0.05, 0.12], [doorW / 2, doorH * 0.42, 0.02]);
    box(leaf, mats.anthracite, [0.05, doorH * 0.5, 0.12], [doorW * 0.28, doorH * 0.56, 0.02]);
    box(leaf, mats.anthracite, [0.05, doorH * 0.5, 0.12], [doorW * 0.72, doorH * 0.56, 0.02]);
    // Slim vision glazing near the top.
    const vision = box(leaf, mats.glass, [doorW - 0.4, 0.5, 0.03], [doorW / 2, doorH - 0.42, 0.04], [0, 0, 0], false);
    vision.castShadow = false;
    // Bar handle parented to the leaf so it swings with the door.
    addHandle(leaf, doorW - 0.14, doorH / 2, 0.08);
    hinge.add(leaf);
    hinge.position.set(-doorW / 2, 0.34, z + 0.03);
    g.add(hinge);
    // Step / threshold.
    box(g, mats.path, [doorW + 0.6, 0.12, 0.5], [0, 0.18, z + 0.28]);
    g.userData.hinge = hinge;
    g.userData.focus = new THREE.Vector3(-1.45, 1.4, HALF_D + 0.2);
    g.position.set(-2.0, 0, 0);
    return g;
  };
  const door = makeDoor();
  house.add(door);

  // 4. Roof lantern sitting in the south roof plane, glazed pyramid + ridge.
  const makeLantern = () => {
    const g = new THREE.Group();
    const baseW = 1.8;
    const baseD = 1.3;
    const kerbH = 0.22;
    // Upstand kerb that ties it into the roof.
    box(g, mats.trim, [baseW + 0.18, kerbH, baseD + 0.18], [0, kerbH / 2, 0]);
    box(g, mats.frame, [baseW, 0.06, baseD], [0, kerbH, 0]);
    // Hipped glazed pyramid built from four sloped glass panes + bars.
    const apex = 0.85;
    const corners = [
      [baseW / 2, kerbH, baseD / 2],
      [-baseW / 2, kerbH, baseD / 2],
      [-baseW / 2, kerbH, -baseD / 2],
      [baseW / 2, kerbH, -baseD / 2],
    ];
    const top = new THREE.Vector3(0, kerbH + apex, 0);
    // Glass faces via flat triangles approximated with thin slanted boxes.
    const faceN = box(g, mats.glass, [baseW + 0.04, 0.02, Math.hypot(baseD / 2, apex)],
      [0, kerbH + apex / 2, -baseD / 4], [Math.atan2(apex, baseD / 2), 0, 0], false);
    const faceS = box(g, mats.glass, [baseW + 0.04, 0.02, Math.hypot(baseD / 2, apex)],
      [0, kerbH + apex / 2, baseD / 4], [-Math.atan2(apex, baseD / 2), 0, 0], false);
    const faceE = box(g, mats.glass, [Math.hypot(baseW / 2, apex), 0.02, baseD + 0.04],
      [baseW / 4, kerbH + apex / 2, 0], [0, 0, -Math.atan2(apex, baseW / 2)], false);
    const faceW = box(g, mats.glass, [Math.hypot(baseW / 2, apex), 0.02, baseD + 0.04],
      [-baseW / 4, kerbH + apex / 2, 0], [0, 0, Math.atan2(apex, baseW / 2)], false);
    [faceN, faceS, faceE, faceW].forEach((f) => { f.castShadow = false; });
    // Hip bars from each corner up to the apex.
    const dir = new THREE.Vector3();
    corners.forEach((c) => {
      const a = new THREE.Vector3(c[0], c[1], c[2]);
      dir.subVectors(top, a);
      const bar = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.02, dir.length(), 8), mats.frame);
      bar.position.copy(a).add(top).multiplyScalar(0.5);
      bar.quaternion.setFromUnitVectors(new THREE.Vector3(0, 1, 0), dir.clone().normalize());
      g.add(bar);
    });
    // Warm interior glow so the lantern reads at a distance.
    const glow = box(g, mats.glassWarm, [baseW - 0.2, 0.02, baseD - 0.2], [0, kerbH - 0.04, 0], [0, 0, 0], false);
    glow.castShadow = false;
    // Seat the lantern on the south roof slope so the kerb sits flush on the
    // tiles (height derived from the slope so it can never float).
    const lz = 0.7;
    const run = HALF_D + ROOF_OVER;
    const rise = RIDGE_H - WALL_H;
    const slopeY = WALL_H + (1 - lz / run) * rise;
    g.position.set(0.6, slopeY - 0.05, lz);
    g.userData.focus = new THREE.Vector3(0.6, slopeY + 0.4, lz);
    return g;
  };
  const lantern = makeLantern();
  house.add(lantern);

  // 5. Commercial curtain-wall wing attached to the back-left of the house.
  const makeCommercial = () => {
    const g = new THREE.Group();
    const cols = 4;
    const rows = 5;
    const cw = 0.7;
    const ch = 0.78;
    const wallW = cols * cw;
    const wallH = rows * ch;
    // Mullion grid + glazing.
    box(g, mats.steel, [wallW + 0.1, 0.08, 0.18], [0, wallH, 0]);
    box(g, mats.steel, [wallW + 0.1, 0.08, 0.18], [0, 0, 0]);
    for (let c = 0; c <= cols; c++) {
      box(g, mats.steel, [0.07, wallH, 0.18], [-wallW / 2 + c * cw, wallH / 2, 0]);
    }
    for (let r = 0; r <= rows; r++) {
      box(g, mats.steel, [wallW, 0.06, 0.16], [0, r * ch, 0]);
    }
    for (let c = 0; c < cols; c++) {
      for (let r = 0; r < rows; r++) {
        const pane = box(g, mats.glass, [cw - 0.08, ch - 0.08, 0.03],
          [-wallW / 2 + cw / 2 + c * cw, ch / 2 + r * ch, 0.0], [0, 0, 0], false);
        pane.castShadow = false;
      }
    }
    // Green spandrel fin echoing the brand.
    box(g, mats.accent, [0.1, wallH, 0.22], [-wallW / 2 - 0.12, wallH / 2, 0]);
    // Flat parapet roof for the wing.
    box(g, mats.render, [wallW + 0.3, 0.18, 1.4], [0, wallH + 0.08, -0.6]);
    g.position.set(-HALF_W - 1.4, 0.34, -1.1);
    g.rotation.y = Math.PI / 2;
    g.userData.focus = new THREE.Vector3(-HALF_W - 1.0, 2.0, -1.1);
    return g;
  };
  const commercial = makeCommercial();
  house.add(commercial);

  // ---- Site / ground --------------------------------------------------------
  const ground = new THREE.Mesh(new THREE.CircleGeometry(26, 48), mats.ground);
  ground.rotation.x = -Math.PI / 2;
  ground.position.y = 0;
  ground.receiveShadow = true;
  root.add(ground);

  const lawn = new THREE.Mesh(new THREE.CircleGeometry(9, 48), mats.lawn);
  lawn.rotation.x = -Math.PI / 2;
  lawn.position.set(0, 0.01, 0);
  lawn.receiveShadow = true;
  root.add(lawn);

  // Garden patio in front of the bifold so the doors open onto something.
  box(root, mats.path, [3.2, 0.06, HALF_D * 2 + 1.4], [HALF_W + 1.6, 0.04, 0], [0, 0, 0], false);
  // Entrance path leading to the front door.
  box(root, mats.path, [1.2, 0.05, 3.4], [-2.0, 0.03, HALF_D + 1.9], [0, 0, 0], false);

  // House sits on the ground at the origin; the camera orbits around it.
  root.position.y = 0;

  // ---- Lighting -------------------------------------------------------------
  const sun = new THREE.DirectionalLight(0xfff1dd, 3.1);
  sun.position.set(6.5, 9, 7.5);
  sun.castShadow = true;
  sun.shadow.mapSize.set(2048, 2048);
  sun.shadow.camera.near = 1;
  sun.shadow.camera.far = 40;
  sun.shadow.camera.left = -12;
  sun.shadow.camera.right = 12;
  sun.shadow.camera.top = 12;
  sun.shadow.camera.bottom = -12;
  sun.shadow.bias = -0.0004;
  sun.shadow.normalBias = 0.02;
  scene.add(sun);
  scene.add(new THREE.HemisphereLight(0xdff1ff, 0x4a6b54, 1.9));
  const fill = new THREE.DirectionalLight(0xbfe0ff, 1.0);
  fill.position.set(-7, 5, -4);
  scene.add(fill);
  scene.add(new THREE.AmbientLight(0xffffff, 0.45));

  // ---- Camera tour ----------------------------------------------------------
  // Each scroll "stop" frames a product. The camera position + look-at target
  // are interpolated between stops, then a constant slow orbit and a little
  // mouse parallax are layered on top.
  const FOCUS = {
    establish: new THREE.Vector3(0.4, 2.0, 0),
    windows: windows.userData.focus,
    bifold: bifold.userData.focus,
    door: door.userData.focus,
    lantern: lantern.userData.focus,
    commercial: commercial.userData.focus,
  };

  // Each stop is an orbit pose around the house.
  //   a = angle around Y (0 = front/+Z, +PI/2 = garden/+X, +PI = back/-Z, -PI/2 = -X)
  //   r = orbit radius, h = camera height, look = target point, fov = lens.
  const STOPS = [
    { a: -0.7, r: 10.5, h: 3.6, look: FOCUS.establish, fov: 40 }, // hero 3/4 wide
    { a: 0.6, r: 6.4, h: 2.2, look: FOCUS.windows, fov: 34 }, // 01 windows (front-right)
    { a: 1.45, r: 6.6, h: 2.0, look: FOCUS.bifold, fov: 34 }, // 02 bifolds (garden gable +X)
    { a: -0.4, r: 5.0, h: 1.8, look: FOCUS.door, fov: 32 }, // 03 door (front-left)
    { a: 0.3, r: 7.2, h: 4.6, look: FOCUS.lantern, fov: 38 }, // 04 lantern (high, looking down)
    { a: -2.3, r: 8.2, h: 3.0, look: FOCUS.commercial, fov: 40 }, // 05 commercial wing (-X/-Z)
  ];

  const steps = [...studioBlock.querySelectorAll('[data-fg-studio-step]')];
  const progressBar = studioBlock.querySelector('[data-fg-home-studio-progress]');
  const pointer = { x: 0, y: 0 };
  let targetProgress = 0;
  let currentProgress = 0;

  const smoothstep = (edge0, edge1, value) => {
    const x = clamp((value - edge0) / Math.max(0.0001, edge1 - edge0));
    return x * x * (3 - 2 * x);
  };

  // Sample the STOPS list at a 0..1 progress value with smooth blending.
  const tmpA = new THREE.Vector3();
  const tmpB = new THREE.Vector3();
  const lookTarget = new THREE.Vector3(0, 1.4, 0);
  const sampleTour = (p) => {
    const span = STOPS.length - 1;
    const scaled = clamp(p) * span;
    const i = Math.min(span - 1, Math.floor(scaled));
    const f = smoothstep(0, 1, scaled - i);
    const s0 = STOPS[i];
    const s1 = STOPS[i + 1];
    const angle = THREE.MathUtils.lerp(s0.a, s1.a, f);
    const radius = THREE.MathUtils.lerp(s0.r, s1.r, f);
    const height = THREE.MathUtils.lerp(s0.h, s1.h, f);
    const fov = THREE.MathUtils.lerp(s0.fov, s1.fov, f);
    tmpA.copy(s0.look);
    tmpB.copy(s1.look);
    lookTarget.copy(tmpA).lerp(tmpB, f);
    return { angle, radius, height, fov };
  };

  const resizeStudio = () => {
    const rect = studioCanvas.getBoundingClientRect();
    const width = Math.max(1, Math.round(rect.width));
    const height = Math.max(1, Math.round(rect.height));
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height, false);
  };

  const updateStudioProgress = () => {
    const rect = studioBlock.getBoundingClientRect();
    const travel = Math.max(1, rect.height - window.innerHeight);
    targetProgress = clamp(-rect.top / travel);
    studioBlock.style.setProperty('--studio-progress', targetProgress.toFixed(4));
    if (progressBar) {
      progressBar.style.transform = `scaleX(${targetProgress.toFixed(4)})`;
    }

    let activeIndex = 0;
    steps.forEach((step, index) => {
      const stepRect = step.getBoundingClientRect();
      const centerDelta = Math.abs((stepRect.top + stepRect.height / 2) - window.innerHeight / 2);
      if (centerDelta < window.innerHeight * 0.46) {
        activeIndex = index;
      }
    });
    steps.forEach((step, index) => {
      step.classList.toggle('is-active', index === activeIndex);
    });

    updateDepthItems();
  };

  window.addEventListener('mousemove', (event) => {
    pointer.x = (event.clientX / window.innerWidth - 0.5) * 2;
    pointer.y = (event.clientY / window.innerHeight - 0.5) * 2;
  }, { passive: true });
  window.addEventListener('scroll', updateStudioProgress, { passive: true });
  window.addEventListener('resize', () => {
    resizeStudio();
    updateStudioProgress();
  });

  const clock = new THREE.Clock();
  const camPos = new THREE.Vector3(0, 4, 12);
  const camLook = new THREE.Vector3(0, 1.4, 0);

  const renderStudio = () => {
    const time = clock.getElapsedTime();
    currentProgress += (targetProgress - currentProgress) * 0.08;
    const p = currentProgress;

    // Product reveals keyed to the scroll position of their stop.
    const winFocus = smoothstep(0.06, 0.24, p);
    const bifoldOpen = smoothstep(0.26, 0.46, p);
    const doorOpen = smoothstep(0.5, 0.7, p);
    const lanternGlow = smoothstep(0.66, 0.84, p);

    // Window: the right casement tilts open gently.
    if (windows.userData.tilt) {
      windows.userData.tilt.rotation.y = -winFocus * 0.5 + Math.sin(time * 0.6) * 0.02 * winFocus;
    }

    // Bifold: panels concertina outward as linked pairs from a fixed jamb.
    const pivots = bifold.userData.pivots || [];
    pivots.forEach((pivot, index) => {
      const fold = (index % 2 === 0 ? 1 : -1) * bifoldOpen * 1.4;
      pivot.rotation.y = fold;
    });

    // Composite door: swings inward on its hinge, handle travels with the leaf.
    if (door.userData.hinge) {
      door.userData.hinge.rotation.y = doorOpen * (Math.PI * 0.46);
    }

    // Lantern: interior glow strengthens; it is fixed to the roof so never floats.
    mats.glassWarm.emissiveIntensity = 0.35 + lanternGlow * 0.9 + Math.sin(time * 1.4) * 0.05 * lanternGlow;

    // Small bounded idle drift (NOT accumulating) so the shot feels alive.
    const idle = Math.sin(time * 0.18) * 0.06;

    const tour = sampleTour(p);
    const angle = tour.angle + idle + pointer.x * 0.16;
    const height = tour.height + pointer.y * -0.4 + Math.sin(time * 0.5) * 0.05;
    const radius = tour.radius;

    camPos.set(
      Math.sin(angle) * radius,
      height,
      Math.cos(angle) * radius,
    );
    camLook.lerp(lookTarget, 0.12);

    camera.position.lerp(camPos, 0.06);
    camera.lookAt(camLook);
    if (Math.abs(camera.fov - tour.fov) > 0.01) {
      camera.fov += (tour.fov - camera.fov) * 0.06;
      camera.updateProjectionMatrix();
    }

    renderer.render(scene, camera);
    requestAnimationFrame(renderStudio);
  };

  resizeStudio();
  updateStudioProgress();
  renderStudio();
}

