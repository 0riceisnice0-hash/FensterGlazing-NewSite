import Lenis from 'lenis';

document.documentElement.classList.add('js');

const legendAssistant = document.querySelector('[data-legend-assistant]');

if (legendAssistant) {
  const panel = legendAssistant.querySelector('[data-legend-panel]');
  const launcherWrap = legendAssistant.querySelector('[data-legend-launcher-wrap]');
  const launcher = legendAssistant.querySelector('[data-legend-launcher]');
  const prompt = legendAssistant.querySelector('[data-legend-prompt]');
  const closeButton = legendAssistant.querySelector('[data-legend-close]');
  const input = legendAssistant.querySelector('[data-legend-input]');
  const sendButton = legendAssistant.querySelector('[data-legend-send]');
  const messages = legendAssistant.querySelector('[data-legend-messages]');
  const composer = legendAssistant.querySelector('[data-legend-composer]');
  const consent = legendAssistant.querySelector('[data-legend-consent]');
  const notice = legendAssistant.querySelector('[data-legend-notice]');
  const clearChatButton = legendAssistant.querySelector('[data-legend-clear]');
  const endpoint = legendAssistant.dataset.legendEndpoint || '';
  const nonce = legendAssistant.dataset.legendNonce || '';
  const sprites = Array.from(legendAssistant.querySelectorAll('[data-legend-sprite]'));
  const sleepSprites = Array.from(legendAssistant.querySelectorAll('[data-legend-sleep-sprite]'));
  const launcherCharacter = legendAssistant.querySelector('[data-legend-character]');
  const roamer = legendAssistant.querySelector('[data-legend-roamer]');
  const roamerSprite = legendAssistant.querySelector('[data-legend-roamer-sprite]');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const quoteFrameWraps = Array.from(document.querySelectorAll('[data-quote-frame-wrap]'));
  let replyTimer = 0;
  let spriteTimer = 0;
  let roamerSpriteTimer = 0;
  let roamerMotionTimer = 0;
  let sleepSpriteTimer = 0;
  let sleepAnimationVersion = 0;
  let inactivityTimer = 0;
  let roamerIsRight = false;
  let isOpen = false;
  let isTransitioning = false;
  let isSleeping = false;
  let wakePromise = null;
  let promptRevealed = false;
  let chatAcknowledged = true;
  let hasSentMessage = false;
  let restoreOpenState = false;
  let chatConversationId = '';
  const conversation = [];
  const welcomeMessage = messages.firstElementChild?.cloneNode(true);
  const chatStorageKey = 'fenster_legend_chat_v1';
  const promptDismissedStorageKey = 'fenster_legend_prompt_dismissed_v1';
  const chatStorageLifetime = 24 * 60 * 60 * 1000;
  const legendInactivityDelay = 20 * 1000;
  const legendCloseSleepDelay = 10 * 1000;
  const promptRevealThreshold = 240;

  const newLegendConversationId = () => `CHT-${(window.crypto?.randomUUID?.() || `${Date.now()}${Math.random()}`).replace(/[^a-z0-9]/gi, '').toUpperCase()}`.slice(0, 84);
  const newLegendMessageId = () => `LCM-${(window.crypto?.randomUUID?.() || `${Date.now()}${Math.random()}`).replace(/[^a-z0-9]/gi, '').toUpperCase()}`.slice(0, 84);

  const setLegendPromptDismissed = (dismissed) => {
    legendAssistant.classList.toggle('is-prompt-dismissed', dismissed);
    try {
      if (dismissed) window.sessionStorage.setItem(promptDismissedStorageKey, '1');
      else window.sessionStorage.removeItem(promptDismissedStorageKey);
    } catch (error) {
      // The visual dismissal still works when browser storage is unavailable.
    }
  };

  const recordLegendTranscript = (role, body) => {
    if (!websiteTracking.chatEndpoint || !chatConversationId || !body) return;
    const hasTrackingConsent = trackingConsentAccepted();
    const journeyId = hasTrackingConsent ? trackWebsiteEvent(role === 'user' ? 'chat_message_sent' : 'chat_reply_received', { cta: 'Legend AI assistant' }) : '';
    const payload = {
      conversation_id: chatConversationId,
      message_id: newLegendMessageId(),
      journey_id: journeyId,
      visitor_id: hasTrackingConsent ? visitorReference() : '',
      page_path: window.location.pathname,
      role,
      body: String(body).slice(0, 900),
    };
    window.fetch(websiteTracking.chatEndpoint, {
      method: 'POST', mode: 'cors', keepalive: true,
      headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload),
    }).catch(() => {});
  };

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

  const sleepSequence = {
    frames: [0, 1, 2, 3, 4, 5, 6, 7],
    timings: [360, 320, 320, 340, 380, 420, 760, 900],
  };

  const showSleepFrame = (column) => {
    sleepSprites.forEach((sprite) => sprite.style.setProperty('--legend-sleep-column', column));
  };

  const runSleepFrames = (frames, timings, onComplete) => {
    window.clearTimeout(sleepSpriteTimer);
    const version = ++sleepAnimationVersion;
    let index = 0;

    const advance = () => {
      if (version !== sleepAnimationVersion) return;
      showSleepFrame(frames[index]);
      const delay = timings[index] || 220;
      index += 1;
      if (index >= frames.length) {
        sleepSpriteTimer = window.setTimeout(() => {
          if (version === sleepAnimationVersion) onComplete?.();
        }, delay);
        return;
      }
      sleepSpriteTimer = window.setTimeout(advance, delay);
    };

    advance();
  };

  const startSleepBreathing = () => {
    legendAssistant.classList.add('is-asleep');
    let breathingFrame = 6;
    const breathe = () => {
      if (!isSleeping) return;
      showSleepFrame(breathingFrame);
      breathingFrame = breathingFrame === 6 ? 7 : 6;
      sleepSpriteTimer = window.setTimeout(breathe, 1200);
    };
    breathe();
  };

  const sleepLegend = () => {
    if (isSleeping || isTransitioning || replyTimer) return;
    isSleeping = true;
    stopRoaming();
    window.clearTimeout(spriteTimer);
    legendAssistant.classList.add('is-sleeping');
    legendAssistant.classList.remove('is-asleep');

    if (reduceMotion.matches) {
      showSleepFrame(7);
      legendAssistant.classList.add('is-asleep');
      return;
    }

    runSleepFrames(sleepSequence.frames, sleepSequence.timings, startSleepBreathing);
  };

  const wakeLegend = () => {
    if (wakePromise) return wakePromise;
    if (!isSleeping) return Promise.resolve();

    wakePromise = new Promise((resolve) => {

      window.clearTimeout(sleepSpriteTimer);
      legendAssistant.classList.remove('is-asleep');
      if (reduceMotion.matches) {
        isSleeping = false;
        legendAssistant.classList.remove('is-sleeping');
        playSprite('idle');
        if (isOpen) startRoaming();
        wakePromise = null;
        resolve();
        return;
      }

      const reverseFrames = [...sleepSequence.frames].reverse();
      runSleepFrames(reverseFrames, reverseFrames.map(() => 120), () => {
        isSleeping = false;
        legendAssistant.classList.remove('is-sleeping');
        playSprite('idle');
        if (isOpen) startRoaming();
        wakePromise = null;
        resolve();
      });
    });
    return wakePromise;
  };

  const scheduleLegendSleep = (delay = legendInactivityDelay) => {
    window.clearTimeout(inactivityTimer);
    inactivityTimer = window.setTimeout(() => {
      if (replyTimer || isTransitioning) {
        scheduleLegendSleep();
        return;
      }
      sleepLegend();
    }, delay);
  };

  const registerLegendActivity = () => {
    scheduleLegendSleep();
    if (isSleeping) void wakeLegend();
  };

  const currentLegendScroll = () => Math.max(
    window.scrollY || 0,
    window.pageYOffset || 0,
    document.scrollingElement?.scrollTop || 0,
    document.documentElement.scrollTop || 0,
    document.body.scrollTop || 0,
  );

  const revealPromptAfterScroll = () => {
    if (promptRevealed || currentLegendScroll() < promptRevealThreshold) return;
    promptRevealed = true;
    legendAssistant.classList.add('is-prompt-visible');
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

    if (isSleeping) return;

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
    let offset = 0;
    const isDialog = Boolean(banner && banner.matches('dialog'));
    const dialogIsOpen = Boolean(isDialog && banner.hasAttribute('open'));
    const bannerIsVisible = Boolean(banner && (isDialog ? dialogIsOpen : !banner.hidden));

    // A native modal belongs to the browser's top layer, so Legend should
    // leave the stage entirely while the visitor makes the required choice.
    // The legacy bottom banner still needs its measured vertical offset.
    legendAssistant.classList.toggle('is-cookie-modal-open', dialogIsOpen);

    if (bannerIsVisible && !isDialog) {
      offset = Math.ceil(banner.getBoundingClientRect().height + 16);
    }

    legendAssistant.style.setProperty('--legend-cookie-offset', `${offset}px`);
  };

  const observeCookieControls = () => {
    const controls = document.querySelectorAll('[data-fg-cookie-consent]');
    const observer = new MutationObserver(syncCookieOffset);
    controls.forEach((control) => observer.observe(control, { attributes: true, attributeFilter: ['hidden', 'open'] }));
    syncCookieOffset();
  };

  const syncQuoteFrameVisibility = () => {
    const quoteFrameLoaded = quoteFrameWraps.some((frameWrap) => (
      frameWrap.classList.contains('is-loaded') || Boolean(frameWrap.querySelector('iframe[src]'))
    ));

    legendAssistant.classList.toggle('is-quote-frame-loaded', quoteFrameLoaded);
  };

  const observeQuoteFrames = () => {
    if (!quoteFrameWraps.length) return;

    const observer = new MutationObserver(syncQuoteFrameVisibility);
    quoteFrameWraps.forEach((frameWrap) => {
      observer.observe(frameWrap, { attributes: true, attributeFilter: ['class'] });
      frameWrap.querySelectorAll('iframe').forEach((iframe) => {
        observer.observe(iframe, { attributes: true, attributeFilter: ['src'] });
      });
    });
    syncQuoteFrameVisibility();
  };

  const resizeInput = () => {
    input.style.height = 'auto';
    input.style.height = `${Math.min(input.scrollHeight, 112)}px`;
  };

  const scrollToLatestMessage = () => {
    messages.scrollTop = messages.scrollHeight;
  };

  const scrollToLatestMessageAfterLayout = () => {
    window.requestAnimationFrame(() => {
      window.requestAnimationFrame(scrollToLatestMessage);
    });
  };

  const syncConsentVisibility = () => {
    if (consent) consent.hidden = hasSentMessage;
  };

  const appendLegendFormatting = (element, text) => {
    const parts = text.split(/(\*\*[^*\n]+\*\*|\[[^\]\n]{1,80}\]\(\/[a-zA-Z0-9_\-/.?=&%#]+\))/g);

    parts.forEach((part) => {
      if (part.startsWith('**') && part.endsWith('**') && part.length > 4) {
        const strong = document.createElement('strong');
        strong.textContent = part.slice(2, -2);
        element.append(strong);
        return;
      }

      const link = part.match(/^\[([^\]\n]{1,80})\]\((\/[a-zA-Z0-9_\-/.?=&%#]+)\)$/);
      if (link) {
        const url = new URL(link[2], window.location.origin);
        if (url.origin === window.location.origin && url.pathname.startsWith('/')) {
          const anchor = document.createElement('a');
          anchor.href = `${url.pathname}${url.search}${url.hash}`;
          anchor.textContent = link[1];
          element.append(anchor);
          return;
        }
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
        hasSentMessage: Boolean(state.hasSentMessage || state.conversation?.some?.((item) => item?.role === 'user')),
        open: Boolean(state.open),
        conversationId: typeof state.conversationId === 'string' ? state.conversationId : '',
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
        hasSentMessage,
        open: isOpen,
        conversationId: chatConversationId,
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
    chatConversationId = state.conversationId || newLegendConversationId();
    hasSentMessage = state.hasSentMessage;
    restoreOpenState = state.open;
    syncConsentVisibility();
    renderConversation();
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
      'main .fg-team-person',
    ].join(','));

    candidates.forEach((element) => {
      const label = element.getAttribute('aria-label') || '';
      const copy = normalisePageText(`${label}\n${element.textContent || ''}`).slice(0, 1600);
      const key = copy.toLowerCase();
      if (!copy || seen.has(key)) return;
      seen.add(key);
      facts.push(copy);
    });

    return facts.slice(0, 24).join('\n\n').slice(0, 12000);
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

    window.clearTimeout(inactivityTimer);
    await wakeLegend();

    isOpen = true;
    persistLegendState();
    if (trackingConsentAccepted()) trackWebsiteEvent('chat_opened', { cta: 'Legend AI assistant' });
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
    scheduleLegendSleep();
    scrollToLatestMessageAfterLayout();
    input.focus();
  };

  const restoreOpenChat = () => {
    if (!restoreOpenState || isOpen) return;

    isOpen = true;
    document.documentElement.classList.add('legend-chat-open');
    panel.hidden = false;
    panel.classList.add('is-restored');
    launcher.setAttribute('aria-expanded', 'true');
    legendAssistant.classList.add('is-open', 'has-arrived');
    roamer?.classList.remove('is-at-right');
    roamerIsRight = false;
    showRoamerFrame(spriteSequences.idle.row, spriteSequences.idle.frames[0]);
    startRoaming();
    scheduleLegendSleep();
    scrollToLatestMessageAfterLayout();
  };

  const closeChat = async ({ sleepAfterClose = false } = {}) => {
    if (isTransitioning || !isOpen) return;

    isTransitioning = true;
    isOpen = false;
    persistLegendState();
    launcher.setAttribute('aria-expanded', 'false');
    stopRoaming();

    const travel = travelLegend(roamer, launcherCharacter, 'down');
    panel.classList.remove('is-restored');
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
    scheduleLegendSleep(sleepAfterClose ? legendCloseSleepDelay : legendInactivityDelay);
    launcher.focus();
  };

  const sendMessage = async () => {
    const text = input.value.trim();
    if (!chatAcknowledged || !text || replyTimer) return;

    registerLegendActivity();

    chatConversationId = chatConversationId || newLegendConversationId();
    hasSentMessage = true;
    syncConsentVisibility();
    addMessage(text, 'user');
    conversation.push({ role: 'user', content: text });
    recordLegendTranscript('user', text);
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
      recordLegendTranscript('assistant', reply);
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
      scheduleLegendSleep();
      input.focus();
    }
  };

  const openLegendFromTrigger = async () => {
    scheduleLegendSleep();
    await wakeLegend();
    await openChat();
  };

  launcher.addEventListener('click', () => {
    void openLegendFromTrigger();
  });
  prompt?.addEventListener('click', (event) => {
    event.stopPropagation();
    setLegendPromptDismissed(true);
  });
  closeButton.addEventListener('click', () => closeChat({ sleepAfterClose: true }));
  clearChatButton?.addEventListener('click', clearLegendChat);
  sendButton.addEventListener('click', sendMessage);
  input.addEventListener('input', () => {
    registerLegendActivity();
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
  legendAssistant.addEventListener('pointerdown', (event) => {
    if (event.target.closest('[data-legend-close], [data-legend-launcher], [data-legend-prompt-action], [data-legend-prompt-close]')) return;
    registerLegendActivity();
  });
  legendAssistant.addEventListener('focusin', (event) => {
    if (event.target.closest('[data-legend-close]')) return;
    registerLegendActivity();
  });
  launcherWrap?.addEventListener('pointerenter', registerLegendActivity);
  messages.addEventListener('wheel', registerLegendActivity, { passive: true });
  messages.addEventListener('touchmove', registerLegendActivity, { passive: true });
  let promptScrollFrame = 0;
  const watchLegendScroll = () => {
    if (promptScrollFrame || promptRevealed) return;
    promptScrollFrame = window.requestAnimationFrame(() => {
      promptScrollFrame = 0;
      revealPromptAfterScroll();
    });
  };
  window.addEventListener('scroll', watchLegendScroll, { passive: true });
  document.addEventListener('scroll', watchLegendScroll, { passive: true, capture: true });
  window.addEventListener('touchmove', watchLegendScroll, { passive: true });
  window.addEventListener('touchend', watchLegendScroll, { passive: true });
  window.visualViewport?.addEventListener('scroll', watchLegendScroll, { passive: true });
  window.addEventListener('resize', syncCookieOffset);
  window.addEventListener('load', syncCookieOffset, { once: true });
  window.addEventListener('storage', (event) => {
    if (event.key !== chatStorageKey || replyTimer) return;
    const state = readLegendState();
    if (!state) return;
    conversation.splice(0, conversation.length, ...state.conversation);
    hasSentMessage = state.hasSentMessage;
    syncConsentVisibility();
    renderConversation();
  });

  legendAssistant.classList.add('is-chat-acknowledged');
  try {
    setLegendPromptDismissed(window.sessionStorage.getItem(promptDismissedStorageKey) === '1');
  } catch (error) {
    setLegendPromptDismissed(false);
  }
  restoreLegendState();
  syncConsentVisibility();
  playSprite('idle');
  showRoamerFrame(spriteSequences.idle.row, spriteSequences.idle.frames[0]);
  revealPromptAfterScroll();
  restoreOpenChat();
  if (!isOpen) scheduleLegendSleep();
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', observeCookieControls, { once: true });
    document.addEventListener('DOMContentLoaded', observeQuoteFrames, { once: true });
  } else {
    observeCookieControls();
    observeQuoteFrames();
  }
}

document.querySelectorAll('[data-fg-composite-carousel]').forEach((carousel) => {
  const track = carousel.querySelector('[data-fg-composite-track]');
  const slides = [...carousel.querySelectorAll('[data-fg-composite-slide]')];
  const panels = [...carousel.querySelectorAll('[data-fg-composite-spec-panel]')];
  const dots = [...carousel.querySelectorAll('[data-fg-composite-dot]')];
  const previous = carousel.querySelector('[data-fg-composite-prev]');
  const next = carousel.querySelector('[data-fg-composite-next]');
  const name = carousel.querySelector('[data-fg-composite-name]');
  const count = carousel.querySelector('[data-fg-composite-count]');

  if (!track || slides.length < 2) return;

  let activeIndex = 0;
  let pointerStart = null;
  let dragDistance = 0;

  const showSlide = (requestedIndex) => {
    activeIndex = (requestedIndex + slides.length) % slides.length;
    track.style.setProperty('--fg-composite-index', String(activeIndex));
    track.style.setProperty('--fg-composite-drag', '0');
    track.classList.remove('is-dragging');
    dragDistance = 0;

    slides.forEach((slide, index) => {
      slide.setAttribute('aria-hidden', index === activeIndex ? 'false' : 'true');
    });
    panels.forEach((panel, index) => {
      panel.hidden = index !== activeIndex;
    });
    dots.forEach((dot, index) => {
      dot.setAttribute('aria-pressed', index === activeIndex ? 'true' : 'false');
    });

    const activeName = slides[activeIndex].querySelector('h3')?.textContent?.trim() || '';
    if (name) name.textContent = activeName;
    if (count) count.textContent = `${String(activeIndex + 1).padStart(2, '0')} / ${String(slides.length).padStart(2, '0')}`;
  };

  previous?.addEventListener('click', () => showSlide(activeIndex - 1));
  next?.addEventListener('click', () => showSlide(activeIndex + 1));
  dots.forEach((dot, index) => dot.addEventListener('click', () => showSlide(index)));

  track.addEventListener('pointerdown', (event) => {
    if (window.matchMedia('(min-width: 861px)').matches) return;
    pointerStart = { id: event.pointerId, x: event.clientX };
    dragDistance = 0;
    track.setPointerCapture(event.pointerId);
    track.classList.add('is-dragging');
  });

  track.addEventListener('pointermove', (event) => {
    if (!pointerStart || event.pointerId !== pointerStart.id) return;
    dragDistance = event.clientX - pointerStart.x;
    track.style.setProperty('--fg-composite-drag', String(dragDistance));
  });

  const finishDrag = (event) => {
    if (!pointerStart || event.pointerId !== pointerStart.id) return;
    const threshold = Math.min(70, track.clientWidth * 0.16);
    const direction = dragDistance < -threshold ? 1 : (dragDistance > threshold ? -1 : 0);
    pointerStart = null;
    showSlide(activeIndex + direction);
  };

  track.addEventListener('pointerup', finishDrag);
  track.addEventListener('pointercancel', finishDrag);
  showSlide(0);
});

document.querySelectorAll('[data-fg-cd-range]').forEach((range) => {
  const tabs = [...range.querySelectorAll('[data-fg-cd-range-tab]')];
  const images = [...range.querySelectorAll('[data-fg-cd-range-image]')];
  const panels = [...range.querySelectorAll('[data-fg-cd-range-panel]')];
  const name = range.querySelector('[data-fg-cd-range-name]');

  const activate = (target) => {
    tabs.forEach((tab) => tab.setAttribute('aria-selected', tab.dataset.fgCdRangeTab === target ? 'true' : 'false'));
    images.forEach((image) => { image.hidden = image.dataset.fgCdRangeImage !== target; });
    panels.forEach((panel) => { panel.hidden = panel.dataset.fgCdRangePanel !== target; });
    const activeTab = tabs.find((tab) => tab.dataset.fgCdRangeTab === target);
    if (name && activeTab) name.textContent = activeTab.querySelector('strong')?.textContent || '';
  };

  tabs.forEach((tab) => tab.addEventListener('click', () => activate(tab.dataset.fgCdRangeTab || '0')));
  if (tabs.length) activate('0');
});

document.querySelectorAll('[data-fg-cd-config]').forEach((config) => {
  const tabs = [...config.querySelectorAll('[data-fg-cd-config-tab]')];
  const panels = [...config.querySelectorAll('[data-fg-cd-config-panel]')];

  const activate = (target) => {
    tabs.forEach((tab) => tab.setAttribute('aria-selected', tab.dataset.fgCdConfigTab === target ? 'true' : 'false'));
    panels.forEach((panel) => { panel.hidden = panel.dataset.fgCdConfigPanel !== target; });
  };

  tabs.forEach((tab) => tab.addEventListener('click', () => activate(tab.dataset.fgCdConfigTab || 'colour')));
  if (tabs.length) activate('colour');
});

/*
 * Composite door wall: a soft continuous drift you can also grab and explore.
 *
 * The track is rendered twice, so scrolling past the halfway point can be
 * rewound by exactly half the scroll width and the loop never shows a seam.
 * Drift is driven by scrollLeft rather than a CSS animation so a drag and the
 * automatic movement act on the same property and cannot fight each other.
 * It pauses on hover, while dragging, and for a moment after a drag, then
 * eases back to drifting once the pointer has left.
 */
document.querySelectorAll('[data-fg-door-wall]').forEach((viewport) => {
  const track = viewport.querySelector('.fg-cd3-wall__track');
  if (!track) return;

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const canDrift = window.matchMedia('(min-width: 861px)');
  // Pixels per frame, so roughly SPEED x 60 per second. Tune here.
  const SPEED = 0.9;
  const RESUME_DELAY = 1400;

  let frame = null;
  let hovering = false;
  let dragging = false;
  let resumeTimer = null;
  let visible = true;
  // The drift is sub-pixel per frame, and reading scrollLeft back rounds that
  // away, so the position is tracked here and written to the element.
  let offset = viewport.scrollLeft;

  const halfway = () => track.scrollWidth / 2;

  // Keep the scroll position inside the first copy of the list.
  const rewind = () => {
    const half = halfway();
    if (half <= 0) return;
    if (offset >= half) offset -= half;
    else if (offset < 0) offset += half;
  };

  const shouldDrift = () =>
    visible && !hovering && !dragging && canDrift.matches && !reduceMotion.matches;

  const stop = () => {
    if (frame === null) return;
    cancelAnimationFrame(frame);
    frame = null;
  };

  const tick = () => {
    if (!shouldDrift()) {
      frame = null;
      return;
    }
    offset += SPEED;
    rewind();
    viewport.scrollLeft = offset;
    frame = requestAnimationFrame(tick);
  };

  const start = () => {
    if (frame !== null || !shouldDrift()) return;
    offset = viewport.scrollLeft;
    frame = requestAnimationFrame(tick);
  };

  const resumeSoon = () => {
    window.clearTimeout(resumeTimer);
    resumeTimer = window.setTimeout(start, RESUME_DELAY);
  };

  viewport.addEventListener('pointerenter', () => {
    hovering = true;
    stop();
  });

  viewport.addEventListener('pointerleave', () => {
    hovering = false;
    if (!dragging) resumeSoon();
  });

  let startX = 0;
  let startScroll = 0;

  viewport.addEventListener('pointerdown', (event) => {
    // Touch keeps native momentum scrolling; only pointer dragging is handled.
    if (event.pointerType === 'touch') return;
    dragging = true;
    startX = event.clientX;
    startScroll = viewport.scrollLeft;
    stop();
    viewport.classList.add('is-dragging');
    viewport.setPointerCapture(event.pointerId);
  });

  viewport.addEventListener('pointermove', (event) => {
    if (!dragging) return;
    event.preventDefault();
    offset = startScroll - (event.clientX - startX);
    rewind();
    viewport.scrollLeft = offset;
  });

  const endDrag = (event) => {
    if (!dragging) return;
    dragging = false;
    viewport.classList.remove('is-dragging');
    if (viewport.hasPointerCapture?.(event.pointerId)) {
      viewport.releasePointerCapture(event.pointerId);
    }
    resumeSoon();
  };

  viewport.addEventListener('pointerup', endDrag);
  viewport.addEventListener('pointercancel', endDrag);

  // Wheel, trackpad and keyboard scrolling move it too; keep our offset in step
  // so the drift picks up from wherever the visitor left it.
  viewport.addEventListener('scroll', () => {
    if (dragging || frame !== null) return;
    offset = viewport.scrollLeft;
  }, { passive: true });

  if ('IntersectionObserver' in window) {
    new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        visible = entry.isIntersecting;
        if (visible) start();
        else stop();
      });
    }, { threshold: 0 }).observe(viewport);
  }

  reduceMotion.addEventListener?.('change', () => (shouldDrift() ? start() : stop()));
  canDrift.addEventListener?.('change', () => (shouldDrift() ? start() : stop()));

  start();
});

/*
 * Composite collections: dots for the mobile swipe carousel. The track is a
 * plain scroll-snap rail, so the dots only have to report which card is
 * nearest the start edge.
 */
document.querySelectorAll('[data-fg-collection-carousel]').forEach((carousel) => {
  const track = carousel.querySelector('.fg-cd3-collections__grid');
  const dots = [...carousel.querySelectorAll('[data-fg-collection-dot]')];
  const cards = track ? [...track.children] : [];
  if (!track || !dots.length || !cards.length) return;

  let ticking = false;
  const sync = () => {
    ticking = false;
    let nearest = 0;
    let best = Infinity;
    cards.forEach((card, index) => {
      const distance = Math.abs(card.offsetLeft - track.scrollLeft - track.clientLeft);
      if (distance < best) {
        best = distance;
        nearest = index;
      }
    });
    dots.forEach((dot, index) => dot.classList.toggle('is-active', index === nearest));
  };

  track.addEventListener('scroll', () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(sync);
  }, { passive: true });

  sync();
});

// The slab layers open one at a time. Only one can be open, so the block never
// grows back into the wall of text it replaced, and the panel keeps a steady
// height instead of shunting the stats down the page as you read.  The first
// layer is open in the markup, so this works as a plain list with JS off.
/*
 * Slab layer explorer.
 *
 * EXACTLY ONE ROW IS OPEN AT ALL TIMES, including on load, and that is a
 * requirement rather than a preference: since 2026-08-27 the drawing beside the
 * list highlights whichever layer is open, so collapsing to nothing would leave
 * a cutaway pointing at a component nobody selected. Clicking the open row is
 * therefore a no-op rather than a close.
 *
 * The only other thing this does is write the open index to the root as
 * `data-active-layer`. Everything visual hangs off that one attribute in the
 * stylesheet, including the leader dot's position, so there are no geometry
 * numbers in here to drift out of step with the ones in the SCSS.
 */
document.querySelectorAll('[data-fg-anatomy]').forEach((explorer) => {
  const toggles = [...explorer.querySelectorAll('[data-fg-anatomy-toggle]')];
  if (!toggles.length) return;

  const open = (toggle) => {
    toggles.forEach((other) => {
      const body = document.getElementById(other.getAttribute('aria-controls'));
      const on = other === toggle;
      other.setAttribute('aria-expanded', on ? 'true' : 'false');
      if (body) body.hidden = !on;
    });
    const index = toggle.dataset.fgAnatomyLayer;
    if (index != null) explorer.dataset.activeLayer = index;
  };

  toggles.forEach((toggle) => {
    toggle.addEventListener('click', () => {
      // Re-clicking the open row used to collapse it. See above.
      if (toggle.getAttribute('aria-expanded') === 'true') return;
      open(toggle);
    });
  });

  // Re-assert from the markup so the attribute and the accordion cannot start
  // out of step if the open row is ever changed in PHP.
  const initial = toggles.find((t) => t.getAttribute('aria-expanded') === 'true') || toggles[0];
  if (initial) open(initial);
});

/*
 * Care guide selector.
 *
 * Every panel is in the markup, so with JavaScript off the page is one long
 * readable document rather than an empty shell. This only narrows it to the
 * chosen product. The URL hash is kept in step so a guide can be linked to
 * directly, which matters when we send somebody a link to the bifold steps.
 */
document.querySelectorAll('[data-fg-care-guides]').forEach((widget) => {
  const tabs = [...widget.querySelectorAll('[data-fg-care-tab]')];
  const panels = [...widget.querySelectorAll('[data-fg-care-panel]')];
  if (!tabs.length || !panels.length) return;

  const activate = (target, { focus = false, setHash = false } = {}) => {
    const known = panels.some((panel) => panel.dataset.fgCarePanel === target);
    if (!known) return;

    tabs.forEach((tab) => {
      const selected = tab.dataset.fgCareTab === target;
      tab.setAttribute('aria-selected', selected ? 'true' : 'false');
      tab.tabIndex = selected ? 0 : -1;
      if (selected && focus) tab.focus();
    });

    panels.forEach((panel) => { panel.hidden = panel.dataset.fgCarePanel !== target; });

    if (setHash && window.history.replaceState) {
      window.history.replaceState(null, '', `#guide-${target}`);
    }
  };

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => activate(tab.dataset.fgCareTab, { setHash: true }));

    // Roving focus, so the picker behaves like a tablist rather than a wall of
    // buttons a keyboard user has to walk through one at a time.
    tab.addEventListener('keydown', (event) => {
      const keys = { ArrowRight: 1, ArrowDown: 1, ArrowLeft: -1, ArrowUp: -1 };
      const step = keys[event.key];
      if (!step) return;
      event.preventDefault();
      const index = tabs.indexOf(tab);
      const next = tabs[(index + step + tabs.length) % tabs.length];
      if (next) activate(next.dataset.fgCareTab, { focus: true, setHash: true });
    });
  });

  const fromHash = (window.location.hash || '').replace(/^#guide-/, '');
  activate(fromHash || tabs[0].dataset.fgCareTab);
});

/*
 * Bi-fold configurations: one swipe rail, with pane-count buttons that jump
 * into it.
 *
 * The rail is the interaction and the buttons are a shortcut into it, so there
 * is one piece of state (where the rail is scrolled to) rather than two that
 * can disagree. Scrolling updates the buttons; pressing a button scrolls the
 * rail. Same model as the colour hub rail the owner approved: native scroll on
 * touch and trackpad, click-drag added for a mouse, and a position counter
 * because a rail with no affordance does not say how much more there is.
 *
 * Progressive enhancement in the honest direction: the rail is a native
 * horizontal scroller with every layout in it before any of this runs, and the
 * controls ship hidden. If anything here throws, the visitor still has all
 * seventeen layouts and can still scroll them.
 */
document.querySelectorAll('[data-fg-bifold-rail]').forEach((rail) => {
  const section = rail.closest('.fg-bfc');
  if (!section) return;

  const controls = section.querySelector('[data-fg-bifold-controls]');
  const jumps = [...section.querySelectorAll('[data-fg-bifold-jump]')];
  const slides = [...rail.querySelectorAll('[data-fg-bifold-slide]')];
  const position = section.querySelector('[data-fg-bifold-position]');
  if (!slides.length) return;

  const pad = () => parseFloat(getComputedStyle(rail).paddingLeft) || 0;

  // Which slide is nearest the rail's left edge, allowing for the track inset.
  const currentIndex = () => {
    const x = rail.scrollLeft + pad();
    let best = 0;
    let bestGap = Infinity;
    slides.forEach((slide, i) => {
      const gap = Math.abs(slide.offsetLeft - x);
      if (gap < bestGap) { bestGap = gap; best = i; }
    });
    return best;
  };

  const sync = () => {
    const index = currentIndex();
    if (position) position.textContent = String(index + 1).padStart(2, '0');
    const panes = slides[index].dataset.panes;
    jumps.forEach((jump) => {
      jump.setAttribute('aria-pressed', jump.dataset.fgBifoldJump === panes ? 'true' : 'false');
    });
  };

  let frame = 0;
  rail.addEventListener('scroll', () => {
    if (frame) return;
    frame = requestAnimationFrame(() => { frame = 0; sync(); });
  }, { passive: true });

  jumps.forEach((jump) => {
    jump.addEventListener('click', () => {
      const target = rail.querySelector(`[data-first-of-count="${jump.dataset.fgBifoldJump}"]`);
      if (!target) return;
      const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      stopGlide();
      rail.scrollTo({ left: target.offsetLeft - pad(), behavior: reduced ? 'auto' : 'smooth' });
    });
  });

  // Click-drag for a mouse, with a flick that carries. Touch and trackpad
  // already scroll natively and are deliberately not bound: binding pointer
  // events wholesale would fight the browser's own touch scrolling.
  //
  // The momentum matters. A drag that stops dead the instant the button comes
  // up is what "not smooth" feels like on a mouse, because every other rail
  // the visitor has ever used coasts. Velocity is sampled over the last two
  // moves rather than the whole drag, so a slow reposition ending in a flick
  // still flicks, and a fast drag ending in a stop still stops.
  let dragging = false;
  let startX = 0;
  let startScroll = 0;
  let moved = 0;
  let lastX = 0;
  let lastT = 0;
  let velocity = 0;
  let glide = 0;

  const stopGlide = () => { if (glide) { cancelAnimationFrame(glide); glide = 0; } };

  rail.addEventListener('pointerdown', (event) => {
    if (event.pointerType !== 'mouse' || event.button !== 0) return;
    stopGlide();
    dragging = true;
    moved = 0;
    velocity = 0;
    startX = lastX = event.clientX;
    lastT = event.timeStamp;
    startScroll = rail.scrollLeft;
    rail.classList.add('is-dragging');
  });

  rail.addEventListener('pointermove', (event) => {
    if (!dragging) return;
    const delta = event.clientX - startX;
    moved = Math.max(moved, Math.abs(delta));
    rail.scrollLeft = startScroll - delta;

    const dt = event.timeStamp - lastT;
    if (dt > 0) velocity = (event.clientX - lastX) / dt;
    lastX = event.clientX;
    lastT = event.timeStamp;
  });

  const endDrag = () => {
    if (!dragging) return;
    dragging = false;
    rail.classList.remove('is-dragging');

    // Below this the visitor was positioning, not flicking, and coasting would
    // feel like the rail slipping out from under them.
    if (Math.abs(velocity) < 0.12) return;

    let v = velocity * 16;
    const step = () => {
      v *= 0.94;
      rail.scrollLeft -= v;
      glide = Math.abs(v) > 0.4 ? requestAnimationFrame(step) : 0;
    };
    glide = requestAnimationFrame(step);
  };

  rail.addEventListener('pointerup', endDrag);
  rail.addEventListener('pointercancel', endDrag);
  rail.addEventListener('pointerleave', endDrag);
  // A new scroll from any other source should win over a dying glide.
  rail.addEventListener('wheel', stopGlide, { passive: true });
  rail.addEventListener('touchstart', stopGlide, { passive: true });

  // A drag that crossed a card would otherwise fire the click on whatever it
  // finished over.
  rail.addEventListener('click', (event) => {
    if (moved > 6) { event.preventDefault(); event.stopPropagation(); }
  }, true);

  if (controls) controls.hidden = false;
  sync();
});

/**
 * The case study install story rail.
 *
 * One step is one photograph the customer took and one line they wrote under
 * it. The rail is a native horizontal scroller first: the controls ship hidden
 * in the markup and are revealed here, so with no JavaScript every step is
 * still present, scrollable and indexable.
 *
 * The two rules this shares with the bi-fold rail are enforced in main.scss,
 * not here: no scroll snap and no `scroll-behavior: smooth` on the rail. The
 * prev/next buttons pass `behavior: 'smooth'` to `scrollTo` themselves, which
 * is the only place that animation belongs.
 *
 * The drag handling is deliberately the same shape as the bi-fold rail's,
 * including the flick that carries, because that is the version the owner
 * signed off as tracking properly. Touch and trackpad already scroll natively
 * and are not bound.
 */
document.querySelectorAll('[data-fg-story-rail]').forEach((rail) => {
  const section = rail.closest('.fg-cs-story');
  if (!section) return;

  const controls = section.querySelector('[data-fg-story-controls]');
  const prevButton = section.querySelector('[data-fg-story-prev]');
  const nextButton = section.querySelector('[data-fg-story-next]');
  const position = section.querySelector('[data-fg-story-position]');
  const steps = [...rail.querySelectorAll('[data-fg-story-step]')];
  if (!steps.length) return;

  const pad = () => parseFloat(getComputedStyle(rail).paddingLeft) || 0;
  // A rail scrolled to its end rarely lands on a whole pixel, so the end test
  // needs slack or the next button never disables on the last step.
  const maxScroll = () => rail.scrollWidth - rail.clientWidth;

  const currentIndex = () => {
    const x = rail.scrollLeft + pad();
    let best = 0;
    let bestGap = Infinity;
    steps.forEach((step, i) => {
      const gap = Math.abs(step.offsetLeft - x);
      if (gap < bestGap) { bestGap = gap; best = i; }
    });
    return best;
  };

  const sync = () => {
    const index = currentIndex();
    if (position) position.textContent = String(index + 1).padStart(2, '0');
    if (prevButton) prevButton.disabled = rail.scrollLeft <= 1;
    if (nextButton) nextButton.disabled = rail.scrollLeft >= maxScroll() - 1;
  };

  let frame = 0;
  rail.addEventListener('scroll', () => {
    if (frame) return;
    frame = requestAnimationFrame(() => { frame = 0; sync(); });
  }, { passive: true });

  let glide = 0;
  const stopGlide = () => { if (glide) { cancelAnimationFrame(glide); glide = 0; } };

  const goTo = (index) => {
    const target = steps[Math.max(0, Math.min(steps.length - 1, index))];
    if (!target) return;
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    stopGlide();
    rail.scrollTo({ left: target.offsetLeft - pad(), behavior: reduced ? 'auto' : 'smooth' });
  };

  prevButton?.addEventListener('click', () => goTo(currentIndex() - 1));
  nextButton?.addEventListener('click', () => goTo(currentIndex() + 1));

  // Arrow keys once the rail itself has focus. It is `tabindex="0"` in the
  // markup because a scrollable region needs to be reachable without a mouse.
  rail.addEventListener('keydown', (event) => {
    if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
    event.preventDefault();
    goTo(currentIndex() + (event.key === 'ArrowRight' ? 1 : -1));
  });

  let dragging = false;
  let startX = 0;
  let startScroll = 0;
  let moved = 0;
  let lastX = 0;
  let lastT = 0;
  let velocity = 0;

  rail.addEventListener('pointerdown', (event) => {
    if (event.pointerType !== 'mouse' || event.button !== 0) return;
    stopGlide();
    dragging = true;
    moved = 0;
    velocity = 0;
    startX = lastX = event.clientX;
    lastT = event.timeStamp;
    startScroll = rail.scrollLeft;
    rail.classList.add('is-dragging');
  });

  rail.addEventListener('pointermove', (event) => {
    if (!dragging) return;
    const delta = event.clientX - startX;
    moved = Math.max(moved, Math.abs(delta));
    rail.scrollLeft = startScroll - delta;

    const dt = event.timeStamp - lastT;
    if (dt > 0) velocity = (event.clientX - lastX) / dt;
    lastX = event.clientX;
    lastT = event.timeStamp;
  });

  const endDrag = () => {
    if (!dragging) return;
    dragging = false;
    rail.classList.remove('is-dragging');

    // Below this the visitor was positioning, not flicking.
    if (Math.abs(velocity) < 0.12) return;

    let v = velocity * 16;
    const step = () => {
      v *= 0.94;
      rail.scrollLeft -= v;
      glide = Math.abs(v) > 0.4 ? requestAnimationFrame(step) : 0;
    };
    glide = requestAnimationFrame(step);
  };

  rail.addEventListener('pointerup', endDrag);
  rail.addEventListener('pointercancel', endDrag);
  rail.addEventListener('pointerleave', endDrag);
  rail.addEventListener('wheel', stopGlide, { passive: true });
  rail.addEventListener('touchstart', stopGlide, { passive: true });

  // A drag that crossed a photograph would otherwise open the lightbox on
  // whatever it finished over.
  rail.addEventListener('click', (event) => {
    if (moved > 6) { event.preventDefault(); event.stopPropagation(); }
  }, true);

  if (controls) controls.hidden = false;
  sync();
  // The rail's scrollWidth is only right once the step images have laid out,
  // and they are lazy, so the end test above can start life wrong.
  window.addEventListener('load', sync);
});

document.querySelectorAll('[data-fg-door-selector]').forEach((selector) => {
  const preview = selector.querySelector('[data-fg-choice-image]');
  const name = selector.querySelector('[data-fg-choice-name]');
  const copy = selector.querySelector('[data-fg-choice-copy]');
  const options = [...selector.querySelectorAll('[data-fg-choice-option]')];
  const modeButtons = [...selector.querySelectorAll('[data-fg-choice-mode]')];

  if (!preview || !options.length) return;

  let selectedOption = options.find((option) => option.getAttribute('aria-pressed') === 'true') || options[0];
  let selectedMode = modeButtons.find((button) => button.getAttribute('aria-pressed') === 'true')?.dataset.fgChoiceMode || 'door';

  const updatePreview = () => {
    const isGlassSelector = selector.hasAttribute('data-fg-glass-selector');
    const prefix = isGlassSelector ? selectedMode : 'preview';
    const source = selectedOption.dataset[`${prefix}Src`];
    const sourceSet = selectedOption.dataset[`${prefix}Srcset`];
    const alt = selectedOption.dataset[`${prefix}Alt`];

    if (source) preview.src = source;
    if (sourceSet) preview.srcset = sourceSet;
    if (alt) preview.alt = alt;
    if (name) name.textContent = selectedOption.dataset.previewName || '';
    if (copy) copy.textContent = selectedOption.dataset.previewCopy || '';

    options.forEach((option) => {
      option.setAttribute('aria-pressed', option === selectedOption ? 'true' : 'false');
    });
    modeButtons.forEach((button) => {
      button.setAttribute('aria-pressed', button.dataset.fgChoiceMode === selectedMode ? 'true' : 'false');
    });
  };

  options.forEach((option) => {
    option.addEventListener('click', () => {
      selectedOption = option;
      updatePreview();
    });
  });

  // The colour wall also previews on hover and on keyboard focus. Click still
  // works, so a touch device is never left without a way to change the preview.
  if (selector.hasAttribute('data-fg-colour-wall')) {
    options.forEach((option) => {
      const show = () => {
        if (option === selectedOption) return;
        selectedOption = option;
        updatePreview();
      };
      option.addEventListener('pointerenter', (event) => {
        if (event.pointerType === 'touch') return;
        show();
      });
      option.addEventListener('focus', show);
    });
  }

  modeButtons.forEach((button) => {
    button.addEventListener('click', () => {
      selectedMode = button.dataset.fgChoiceMode || 'door';
      updatePreview();
    });
  });

  updatePreview();
});

document.querySelectorAll('[data-fg-sash-furniture]').forEach((selector) => {
  const styleButtons = [...selector.querySelectorAll('[data-fg-furniture-style]')];
  const panels = [...selector.querySelectorAll('[data-fg-furniture-panel]')];
  const images = [...selector.querySelectorAll('[data-fg-furniture-image]')];

  const showFinish = (assetKey) => {
    images.forEach((image) => {
      image.hidden = image.dataset.fgFurnitureImage !== assetKey;
    });
    selector.querySelectorAll('[data-fg-furniture-finish]').forEach((button) => {
      button.setAttribute('aria-pressed', button.dataset.fgFurnitureFinish === assetKey ? 'true' : 'false');
    });
  };

  styleButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const style = button.dataset.fgFurnitureStyle;
      styleButtons.forEach((item) => item.setAttribute('aria-pressed', item === button ? 'true' : 'false'));
      panels.forEach((panel) => {
        panel.hidden = panel.dataset.fgFurniturePanel !== style;
      });
      const firstFinish = selector.querySelector(`[data-fg-furniture-panel="${style}"] [data-fg-furniture-finish]`);
      if (firstFinish) showFinish(firstFinish.dataset.fgFurnitureFinish);
    });
  });

  selector.querySelectorAll('[data-fg-furniture-finish]').forEach((button) => {
    button.addEventListener('click', () => showFinish(button.dataset.fgFurnitureFinish));
  });
});

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
const aggregateStatEvents = new Set([
  'page_view',
  'page_engaged',
  'quote_opened',
  'quote_iframe_loaded',
  'form_started',
  'form_submitted',
  'phone_click',
  'email_click',
]);
const journeyStorageKey = 'fenster_quote_journey_ref';
const visitorStorageKey = 'fenster_website_visitor_id';
const marketingAttributionStorageKey = 'fenster_marketing_attribution_ref';
const firstTouchStorageKey = 'fenster_website_first_touch';
const trackingStorageLifetime = 90 * 24 * 60 * 60 * 1000;
const journeySessionTimeout = Math.max(5, Number(websiteTracking.sessionTimeoutMinutes) || 30) * 60 * 1000;

/* `chosen` is RECORDED but deliberately NOT REQUIRED here, matching
   `validPreferences()` in `inc/consent.php`. Optional cookies are granted by
   default, so requiring it would invalidate every existing record and re-prompt
   the whole audience for no gain — they are being tracked either way. Written
   only by the banner's own save path, so a record carrying it is one the visitor
   actually chose, which is the only way to tell a real answer from an assumed
   one. If the default is ever flipped back to off, add `record.chosen === true`
   here and in `inc/consent.php` together.

   Corrected 2026-08-26. This comment claimed the opposite for fourteen days,
   left behind by the consent-first flip of 2026-08-11 that the owner reverted on
   the 12th. The code below was never wrong; the comment describing it was, on
   the one function pair `AI.md` says must be kept in step by hand. */
const validCookieConsentRecord = (record) => Boolean(
  record
  && record.version === 2
  && typeof record.analytics === 'boolean'
  && typeof record.marketing === 'boolean'
  && Number(record.expires_at) > Date.now(),
);

// The banner publishes the live choice on `window` as well as writing it to
// local storage, and this reads the published copy when storage gives nothing
// back. Storage is not always writable — a browser set to block all site data
// throws on setItem — and the write is swallowed, so without this fallback a
// visitor who pressed "Accept all" still read as having made no choice: no
// journey id and every WindowCAD link left stamped as a refusal. It cannot
// outlive the page, which is the honest limit of a browser that refuses to
// remember.
const storedCookieConsent = () => {
  try {
    const raw = window.localStorage.getItem('fenster_cookie_consent');
    const stored = raw ? JSON.parse(raw) : null;
    if (validCookieConsentRecord(stored)) return stored;
  } catch (_error) {}
  return validCookieConsentRecord(window.fensterCookieConsent) ? window.fensterCookieConsent : null;
};

/* Optional cookies are GRANTED by default and stay on until refused.
   This file runs before `inc/consent.php`'s inline script, so it cannot wait to
   be told the default — it has to carry the same one, and the two must not be
   allowed to drift. Change one and change the other.

   Identifiers are therefore issued before the banner is answered, which is why
   a refusal has to erase as well as stop. See `withdrawTrackedData`. */
const defaultCookieConsent = () => ({
  version: 2,
  analytics: true,
  marketing: true,
  chosen: false,
  expires_at: Date.now() + (180 * 24 * 60 * 60 * 1000),
});

const cookieConsentPreferences = () => storedCookieConsent() || defaultCookieConsent();

const trackingConsentAccepted = () => {
  const preferences = cookieConsentPreferences();
  return Boolean(preferences && preferences.analytics);
};

const marketingConsentAccepted = () => {
  const preferences = cookieConsentPreferences();
  return Boolean(preferences && preferences.marketing);
};

/* Whether a real choice is stored. Under granted-by-default the first branch of
   the WindowCAD value answers for everyone who has not refused, so this decides
   between `rejected-cookies` for somebody who said no and
   `cookie-consent-not-accepted`, which is effectively unreachable while the
   default is on and survives so flipping the default back restores it. */
const cookieConsentChoiceMade = () => Boolean(storedCookieConsent());

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

const createMarketingAttributionReference = () => {
  const random = window.crypto?.randomUUID?.().replace(/-/g, '').slice(0, 18)
    || `${Date.now().toString(36)}${Math.random().toString(36).slice(2, 12)}`;
  return `FGA-${random.toUpperCase()}`;
};

const validTrackingReference = (value, prefix) => new RegExp(`^${prefix}-[A-Z0-9-]{8,80}$`, 'i').test(value || '');

/* Every write below is mirrored here, and every read falls back to it. When
   storage is unwritable the mirror is the only thing holding a journey together:
   without it `journeyReference()` fails to persist, finds nothing on the next
   call and mints another id, so a single page view would report itself as half a
   dozen one-event journeys and the id stamped into WindowCAD would match none of
   them. Page-scoped by nature, which is as far as a browser that will not store
   anything can be carried. */
const trackingMemoryStore = new Map();

const liveTrackingRecord = (record, validator) => Boolean(
  record && validator(record.value) && Number(record.expires_at) > Date.now(),
);

const readStoredTrackingValue = (key, validator) => {
  try {
    const raw = window.localStorage.getItem(key);
    const record = raw ? JSON.parse(raw) : null;
    if (liveTrackingRecord(record, validator)) return record.value;
    window.localStorage.removeItem(key);
  } catch (_error) {}

  const remembered = trackingMemoryStore.get(key);
  return liveTrackingRecord(remembered, validator) ? remembered.value : '';
};

const storeTrackingValue = (key, value) => {
  if (!trackingConsentAccepted()) return;
  const record = { value, expires_at: Date.now() + trackingStorageLifetime };
  trackingMemoryStore.set(key, record);
  try {
    window.localStorage.setItem(key, JSON.stringify(record));
  } catch (_error) {}
};

const liveJourneyRecord = (record) => {
  const now = Date.now();
  return Boolean(
    record
    && validTrackingReference(record.value, 'FG2')
    && Number(record.expires_at) > now
    && now - Number(record.last_seen_at || 0) <= journeySessionTimeout,
  );
};

const readJourneyReference = () => {
  let record = null;

  try {
    const raw = window.localStorage.getItem(journeyStorageKey);
    const stored = raw ? JSON.parse(raw) : null;
    if (liveJourneyRecord(stored)) {
      record = stored;
    } else {
      window.localStorage.removeItem(journeyStorageKey);
    }
  } catch (_error) {}

  if (!record) {
    const remembered = trackingMemoryStore.get(journeyStorageKey);
    if (liveJourneyRecord(remembered)) record = remembered;
  }
  if (!record) return '';

  // Touching the session keeps the 30 minute window open. The original expiry
  // stays put, so this rolls the session on without extending the 90 day life.
  record.last_seen_at = Date.now();
  trackingMemoryStore.set(journeyStorageKey, record);
  try {
    window.localStorage.setItem(journeyStorageKey, JSON.stringify(record));
  } catch (_error) {}

  return record.value;
};

const storeJourneyReference = (value) => {
  if (!trackingConsentAccepted()) return;
  const now = Date.now();
  const record = {
    value,
    last_seen_at: now,
    expires_at: now + trackingStorageLifetime,
  };
  trackingMemoryStore.set(journeyStorageKey, record);
  try {
    window.localStorage.setItem(journeyStorageKey, JSON.stringify(record));
  } catch (_error) {}
};

const storeMarketingValue = (key, value) => {
  if (!marketingConsentAccepted()) return;
  try {
    window.localStorage.setItem(key, JSON.stringify({ value, expires_at: Date.now() + trackingStorageLifetime }));
  } catch (_error) {}
};

const journeyReference = () => {
  if (!trackingConsentAccepted()) return '';
  const existing = readJourneyReference();
  if (existing) return existing;
  const created = createJourneyReference();
  storeJourneyReference(created);
  return created;
};

const visitorReference = () => {
  if (!trackingConsentAccepted()) return '';
  const existing = readStoredTrackingValue(visitorStorageKey, (value) => validTrackingReference(value, 'FGV'));
  if (existing) return existing;
  const created = createVisitorReference();
  storeTrackingValue(visitorStorageKey, created);
  return created;
};

/* The ad reference is consent-free, and that is the whole reason paid search
   stays measurable whatever the visitor chooses.

   It is derived SERVER-SIDE from the click id in the landing URL and handed
   back by `/wp-json/fenster/v1/ad-click`. Reading the address of a page
   somebody just requested stores nothing on their device, so it needs no
   permission — unlike everything below it, which persists and therefore does.

   It is fetched rather than rendered into the page because the landing page is
   proxy-cached by path: a reference printed into the HTML would be served to
   every later visitor of that page, and would never reach the visitor it
   belonged to. See the note on the REST route.

   Prefer it, so a visitor who refuses cookies or never answers the banner still
   has their click joined to the quote or form they go on to send. The stored
   branch underneath is kept for consenting visitors, where it survives
   navigation that the URL-derived value cannot. */
let serverAdReference = '';

const marketingAttributionReference = () => {
  const supplied = serverAdReference.trim();
  if (validTrackingReference(supplied, 'FGA')) return supplied;

  if (!marketingConsentAccepted()) return '';
  const existing = readStoredTrackingValue(
    marketingAttributionStorageKey,
    (value) => validTrackingReference(value, 'FGA'),
  );
  if (existing) return existing;
  const created = createMarketingAttributionReference();
  storeMarketingValue(marketingAttributionStorageKey, created);
  return created;
};

// WindowCAD's `ads` URL field is its own source tracker, separate from the
// consented FG2 journey carried in `tracking`. Google Ads supplies the real
// ad-group ID through its {adgroupid} ValueTrack parameter. Preserve a legacy
// text label too so the existing Meta/Google quote links continue to work.
const adTrackerStorageKey = 'fenster_ads_tracker';
const validAdTrackerValue = (value) => /^[A-Za-z0-9 _.-]{1,80}$/.test(value || '');
const adTrackerReference = () => {
  /* Read from the URL without consent, for the same reason as the reference
     above: this value is in the address bar, not in storage. `storeMarketingValue`
     keeps its own consent guard, so nothing is persisted without permission —
     only the reading of what the visitor's own request already contained is
     freed. Without this the office loses the ad-group tracker on every
     WindowCAD quote from a visitor who has not answered the banner, which is
     most of them. */
  const current = (new URLSearchParams(window.location.search).get('ads') || '').trim();
  if (validAdTrackerValue(current)) {
    storeMarketingValue(adTrackerStorageKey, current);
    return current;
  }

  // The stored fallback survives navigation, and storage needs consent.
  if (!marketingConsentAccepted()) return '';
  return readStoredTrackingValue(adTrackerStorageKey, validAdTrackerValue);
};

// A Google Ads click carries a click identifier. It only carries utm_source and
// utm_medium if the account's Final URL suffix is set, and a campaign missing
// that suffix fails silently: the journey lands with an empty source and a
// google.com referrer, which is indistinguishable from organic. On 2026-08-05
// only 15 of roughly 183 Google journeys read as cpc for exactly that reason.
// Derive the channel from the presence of the identifier so paid can never be
// filed as organic. The identifier itself is not read, stored or sent here;
// only the channel labels below travel to the dashboard, which keeps the
// tracker's rule that ad click ids never reach it. Real UTM values still win,
// so the Final URL suffix remains the source of campaign and keyword detail.
const paidClickChannel = (parameters) => {
  const present = ['gclid', 'gbraid', 'wbraid']
    .some((key) => (parameters.get(key) || '').trim() !== '');
  return present ? { source: 'google', medium: 'cpc' } : null;
};

const currentCampaignContext = () => {
  const parameters = new URLSearchParams(window.location.search);
  const paidClick = paidClickChannel(parameters);
  return {
    landing_path: window.location.pathname,
    source: parameters.get('utm_source') || (paidClick ? paidClick.source : ''),
    medium: parameters.get('utm_medium') || (paidClick ? paidClick.medium : ''),
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
    const journeyId = journeyReference();
    const raw = window.localStorage.getItem(firstTouchStorageKey);
    const stored = raw ? JSON.parse(raw) : null;
    if (stored && stored.journey_id === journeyId && Number(stored.expires_at) > Date.now() && stored.context) {
      return { page_path: window.location.pathname, ...stored.context };
    }
    const context = { ...current };
    window.localStorage.setItem(firstTouchStorageKey, JSON.stringify({
      journey_id: journeyId,
      context,
      expires_at: Date.now() + trackingStorageLifetime,
    }));
    return { page_path: window.location.pathname, ...context };
  } catch (_error) {
    return { page_path: window.location.pathname, ...current };
  }
};

const aggregateStatDevice = () => {
  if (window.matchMedia?.('(max-width: 600px)').matches) return 'mobile';
  if (window.matchMedia?.('(max-width: 1024px)').matches) return 'tablet';
  return 'desktop';
};

const trackAggregateStat = (event, detail = {}) => {
  if (!websiteTracking.statEndpoint || !aggregateStatEvents.has(event)) return;
  try {
    if (window.localStorage.getItem('fenster_statistical_optout') === '1') return;
  } catch (_error) {}
  const body = JSON.stringify({
    event,
    page_path: window.location.pathname,
    referrer_host: (() => {
      try { return document.referrer ? new URL(document.referrer).hostname : ''; } catch (_error) { return ''; }
    })(),
    device_type: aggregateStatDevice(),
    origin: window.location.origin,
    environment: websiteTracking.environment || '',
    ...detail,
  });
  if (navigator.sendBeacon) {
    navigator.sendBeacon(websiteTracking.statEndpoint, new Blob([body], { type: 'text/plain;charset=UTF-8' }));
  } else {
    window.fetch(websiteTracking.statEndpoint, {
      method: 'POST',
      mode: 'cors',
      keepalive: true,
      headers: { 'Content-Type': 'text/plain;charset=UTF-8' },
      body,
    }).catch(() => {});
  }
};

document.querySelectorAll('[data-fg-statistics-optout]').forEach((button) => {
  try {
    if (window.localStorage.getItem('fenster_statistical_optout') === '1') button.textContent = 'Anonymous statistics excluded';
  } catch (_error) {}
  button.addEventListener('click', () => {
    try { window.localStorage.setItem('fenster_statistical_optout', '1'); } catch (_error) {}
    button.textContent = 'Anonymous statistics excluded';
  });
});

const websiteEventQueueKey = 'fenster_website_event_queue';
const createWebsiteEventId = () => window.crypto?.randomUUID?.()
  || `FGE-${Date.now().toString(36)}-${Math.random().toString(36).slice(2, 12)}`;

const queueWebsiteEvent = (payload) => {
  if (!trackingConsentAccepted()) return;
  try {
    const queued = JSON.parse(window.localStorage.getItem(websiteEventQueueKey) || '[]');
    const events = Array.isArray(queued) ? queued : [];
    if (!events.some((item) => item?.event_id === payload.event_id)) events.push(payload);
    window.localStorage.setItem(websiteEventQueueKey, JSON.stringify(events.slice(-50)));
  } catch (_error) {}
};

const sendWebsiteEvent = (payload) => {
  if (!websiteTracking.endpoint) return;
  const body = JSON.stringify(payload);

  if (window.fetch) {
    window.fetch(websiteTracking.endpoint, {
      method: 'POST',
      mode: 'cors',
      keepalive: true,
      headers: { 'Content-Type': 'text/plain;charset=UTF-8' },
      body,
    }).then((response) => {
      if (!response.ok) throw new Error(`Tracking endpoint returned ${response.status}`);
    }).catch(() => queueWebsiteEvent(payload));
    return;
  }

  if (!navigator.sendBeacon?.(websiteTracking.endpoint, new Blob([body], { type: 'text/plain;charset=UTF-8' }))) {
    queueWebsiteEvent(payload);
  }
};

const flushWebsiteEventQueue = () => {
  if (!trackingConsentAccepted() || !websiteTracking.endpoint || !window.fetch) return;
  let queued = [];
  try {
    queued = JSON.parse(window.localStorage.getItem(websiteEventQueueKey) || '[]');
    window.localStorage.removeItem(websiteEventQueueKey);
  } catch (_error) {}
  if (Array.isArray(queued)) queued.slice(-50).forEach(sendWebsiteEvent);
};

const sendGoogleAdsConversion = (type, eventId = createWebsiteEventId()) => {
  if (!marketingConsentAccepted() || typeof window.gtag !== 'function') return;
  const ads = websiteTracking.googleAds || {};
  const label = {
    enquiry: ads.enquiryLabel,
    consultation: ads.consultationLabel,
    phone: ads.phoneLabel,
    quote: ads.quoteLabel,
  }[type];
  if (!ads.conversionId || !label) return;
  window.gtag('event', 'conversion', {
    send_to: `${ads.conversionId}/${label}`,
    event_id: eventId,
  });
};

const trackWebsiteEvent = (event, detail = {}) => {
  const analyticsAccepted = trackingConsentAccepted();
  const marketingAccepted = marketingConsentAccepted();
  if (!analyticsAccepted) trackAggregateStat(event, detail);
  const payload = {
    event_id: createWebsiteEventId(),
    event,
    journey_id: journeyReference(),
    visitor_id: visitorReference(),
    environment: websiteTracking.environment || '',
    ...campaignContext(),
    ...detail,
  };

  if (marketingAccepted) {
    if (event === 'phone_click') sendGoogleAdsConversion('phone', payload.event_id);
    if (event === 'quote_opened') sendGoogleAdsConversion('quote', payload.event_id);
    if (typeof window.fbq === 'function') {
      const metaEvent = {
        phone_click: 'Contact',
        email_click: 'Contact',
        quote_opened: 'InitiateCheckout',
      }[event];
      if (metaEvent) {
        window.fbq('track', metaEvent, {
          content_name: detail.cta || event,
          content_category: 'Fenster website',
        }, { eventID: payload.event_id });
      }
    }
  }

  if (!analyticsAccepted) {
    if (marketingAccepted) {
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push({
        event: `fenster_${event}`,
        event_id: payload.event_id,
        page_path: payload.page_path,
        cta: detail.cta || '',
      });
    }
    return payload.journey_id;
  }

  window.dataLayer = window.dataLayer || [];
  window.dataLayer.push({ ...payload, event: `fenster_${event}` });
  if (typeof window.gtag === 'function') {
    window.gtag('event', `fenster_${event}`, {
      page_path: payload.page_path,
      cta: detail.cta || '',
      product_collection: detail.product_collection || '',
      value: Number(detail.price_amount || 0),
      currency: detail.price_currency || 'GBP',
      event_id: payload.event_id,
    });
  }
  if (typeof window.clarity !== 'function') {
    window.clarity = function (...args) {
      (window.clarity.q = window.clarity.q || []).push(args);
    };
  }
  window.clarity?.('event', `fenster_${event}`);

  sendWebsiteEvent(payload);

  return payload.journey_id;
};

flushWebsiteEventQueue();

const windowCadUrlWithReference = (value) => {
  if (!value || !/windowsoftware\.co\.uk\/windowcad7/i.test(value)) return value;

  try {
    const url = new URL(value, window.location.href);
    /* Four outcomes, in order of
       preference: a consented journey; failing that the URL-derived ad
       reference, which needs no consent and is what keeps a paid lead
       attributable; then `rejected-cookies` for somebody who was asked and said
       no; then `cookie-consent-not-accepted` for somebody who has not answered
       yet. The last two are different facts and the office should be able to
       tell them apart. */
    const trackingValue = journeyReference()
      || marketingAttributionReference()
      || (cookieConsentChoiceMade() ? 'rejected-cookies' : 'cookie-consent-not-accepted');
    url.searchParams.set(websiteTracking.referenceParameter || 'reference', trackingValue);
    const adsTracker = adTrackerReference();
    if (adsTracker) url.searchParams.set('ads', adsTracker);
    return url.toString();
  } catch (_error) {
    return value;
  }
};

const windowCadLinks = [...document.querySelectorAll('a[href*="windowsoftware.co.uk/windowcad7/"]')];
const refreshWindowCadLinks = () => {
  windowCadLinks.forEach((link) => {
    if (!link.dataset.fgQuoteBaseUrl) link.dataset.fgQuoteBaseUrl = link.href;
    link.href = windowCadUrlWithReference(link.dataset.fgQuoteBaseUrl);
  });
};

windowCadLinks.forEach((link) => {
  link.addEventListener('click', () => {
    link.href = windowCadUrlWithReference(link.dataset.fgQuoteBaseUrl || link.href);
    trackWebsiteEvent('quote_opened', {
      cta: (link.textContent || 'WindowCAD link').trim().slice(0, 120),
      product_collection: new URL(link.href).searchParams.get('productCollection') || '',
    });
  });
});

refreshWindowCadLinks();

const populateTrackingFields = (scope = document) => {
  scope.querySelectorAll('[data-fg-journey-ref]').forEach((field) => {
    field.value = journeyReference();
  });
  scope.querySelectorAll('[data-fg-visitor-id]').forEach((field) => {
    field.value = visitorReference();
  });
  scope.querySelectorAll('[data-fg-analytics-consent]').forEach((field) => {
    field.value = trackingConsentAccepted() ? '1' : '0';
  });
  scope.querySelectorAll('[data-fg-marketing-consent]').forEach((field) => {
    field.value = marketingConsentAccepted() ? '1' : '0';
  });
  /* Deliberately outside the consent flags above. This reference is derived
     from the visitor's own landing URL and stored on nothing, so withholding it
     would lose the campaign behind a lead without protecting anybody. */
  scope.querySelectorAll('[data-fg-marketing-ref]').forEach((field) => {
    field.value = marketingAttributionReference();
  });
};

populateTrackingFields();

// Google Ads click ids identify the ad click behind a lead, so a job we win can
// be reported back to Google as an offline conversion and bidding can learn what
// actually sells. The value travels with the enquiry to WordPress only: it is
// never added to a dashboard payload, per the tracker's privacy boundary.
const adClickStorageKey = 'fenster_ad_click_id';
const validAdClickValue = (value) => /^(gclid|gbraid|wbraid):[A-Za-z0-9_\-.]{10,200}$/.test(value || '');

const adClickReference = () => {
  if (!marketingConsentAccepted()) return '';
  const parameters = new URLSearchParams(window.location.search);
  for (const key of ['gclid', 'gbraid', 'wbraid']) {
    const captured = `${key}:${(parameters.get(key) || '').trim()}`;
    if (validAdClickValue(captured)) {
      storeMarketingValue(adClickStorageKey, captured);
      return captured;
    }
  }
  return readStoredTrackingValue(adClickStorageKey, validAdClickValue);
};

const populateAdClickFields = (scope = document) => {
  const captured = adClickReference();
  scope.querySelectorAll('[data-fg-ad-click-id]').forEach((field) => {
    field.value = captured;
  });
  const adsTracker = adTrackerReference();
  scope.querySelectorAll('[data-fg-ad-tracker]').forEach((field) => {
    field.value = adsTracker;
  });
};

populateAdClickFields();

let lastAdAttributionSync = '';
const syncAdAttribution = () => {
  if (!marketingConsentAccepted() || !websiteTracking.adAttributionEndpoint) return;
  const journeyId = journeyReference() || marketingAttributionReference();
  const clickId = adClickReference();
  const adsTracker = adTrackerReference();
  if (!validTrackingReference(journeyId, 'FG2') && !validTrackingReference(journeyId, 'FGA')) return;

  const syncKey = `${journeyId}:${clickId}:${adsTracker}`;
  if (syncKey === lastAdAttributionSync) return;
  lastAdAttributionSync = syncKey;

  window.fetch(websiteTracking.adAttributionEndpoint, {
    method: 'POST',
    credentials: 'same-origin',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      journey_id: journeyId,
      ad_click_id: clickId,
      ads_tracker: adsTracker,
      marketing_consent: true,
    }),
  }).catch(() => {
    lastAdAttributionSync = '';
  });
};

syncAdAttribution();

/* Report the ad click from the browser, because the landing page is cached.

   SiteGround's proxy serves these pages by path and ignores the query string,
   so a paid arrival never reaches PHP and the server cannot see its own gclid.
   The browser can: it is running on the cached page with the real URL in the
   address bar. It forwards the query string to a REST route, which is not
   cached, and gets back the one-way reference.

   Everything sensitive stays on the server — the hashing, the salt, the stored
   context and the dashboard relay. This sends only the query string the visitor
   was already given, and stores nothing on their device, so it stays outside
   consent for the same reason the rest of layer 1 does.

   The re-stamp afterwards matters: forms and the WindowCAD URL were already
   populated with whatever was available at load, and the reference arrives a
   moment later. Without it the very lead this exists to attribute goes out
   unstamped. */
const reportAdClick = () => {
  const endpoint = websiteTracking.adClickEndpoint;
  const search = window.location.search;
  if (!endpoint || !window.fetch) return;
  if (!/[?&](gclid|gbraid|wbraid)=[^&]/.test(search)) return;

  window.fetch(endpoint, {
    method: 'POST',
    credentials: 'same-origin',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ search, path: window.location.pathname }),
  })
    .then((response) => (response.ok ? response.json() : null))
    .then((data) => {
      const reference = (data && data.reference) || '';
      if (!validTrackingReference(reference, 'FGA')) return;
      serverAdReference = reference;
      populateTrackingFields();
      populateAdClickFields();
      refreshWindowCadLinks();
      syncAdAttribution();
      // Only re-points an untouched frame; a part-built quote is left alone.
      document.querySelectorAll('[data-quote-frame-wrap]').forEach(restampQuoteFrame);
    })
    .catch(() => {});
};

reportAdClick();

// A visitor arriving from an ad meets the cookie banner before they reach a
// form, and accepting is what allows the id to be stored at all. Without this
// second pass the click id is captured into the field but never persisted, so
// it is lost the moment they open a second page. The banner dispatches on
// window, not document.
window.addEventListener('fenster:tracking-consent-accepted', () => {
  populateTrackingFields();
  populateAdClickFields();
  refreshWindowCadLinks();
  flushWebsiteEventQueue();
  syncAdAttribution();
});
window.addEventListener('fenster:cookie-preferences-updated', () => {
  populateTrackingFields();
  populateAdClickFields();
  refreshWindowCadLinks();
  syncAdAttribution();
});

let consentedPageRecorded = false;
if (trackingConsentAccepted()) {
  consentedPageRecorded = true;
  trackWebsiteEvent('visitor_seen');
  trackWebsiteEvent('page_view');
} else {
  trackAggregateStat('page_view');
}

window.addEventListener('fenster:tracking-consent-accepted', () => {
  if (consentedPageRecorded || !trackingConsentAccepted()) return;
  consentedPageRecorded = true;
  trackWebsiteEvent('visitor_seen');
  trackWebsiteEvent('page_view');
});

const pageTrackingStartedAt = Date.now();
let pageEngagementRecorded = false;
const recordPageEngagement = () => {
  if (pageEngagementRecorded) return;
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
  if (!action || action.closest('[data-fg-cookie-consent]') || action.matches('[type="submit"]')) return;
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

    const chooseAudience = (choice, moveFocus = true) => {
      audienceChoices.forEach((button) => {
        const active = button === choice;
        button.classList.toggle('is-active', active);
        button.setAttribute('aria-pressed', active ? 'true' : 'false');
      });

      const projectType = choice.dataset.projectType || choice.textContent?.trim() || projectTypeField.value;
      projectTypeField.value = projectType;
      form.classList.add('is-audience-selected');
      audienceBody.removeAttribute('hidden');
      if (moveFocus) audienceBody.querySelector('input, select, textarea')?.focus?.({ preventScroll: true });
    };

    audienceChoices.forEach((choice) => {
      choice.addEventListener('click', () => chooseAudience(choice));
    });

    // The template pre-selects the audience the page is already speaking to, so
    // open straight onto the form rather than making everyone answer it first.
    const preselected = audienceChoices.find((choice) => choice.getAttribute('aria-pressed') === 'true');
    if (preselected) chooseAudience(preselected, false);
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
    populateTrackingFields(form);
    populateAdClickFields(form);
    syncAdAttribution();
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
      const consultationBooking = Boolean(form.querySelector('[data-fg-consultation-booking]'));
      if (marketingConsentAccepted()) {
        // Google Tag Manager can only fire an Ads conversion from something it
        // sees in the browser. The dashboard already receives form_submitted
        // server-side from inc/enquiries.php, so this is a dataLayer push only:
        // routing it through trackWebsiteEvent would double count the lead.
        const conversionEventId = Number(result.enquiry_id || 0) > 0
          ? `wp-form-${Number(result.enquiry_id)}`
          : createWebsiteEventId();
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
          event: consultationBooking ? 'fenster_consultation_booked' : 'fenster_form_submitted',
          event_id: conversionEventId,
          form_context: formContext(),
          page_path: window.location.pathname,
        });
        sendGoogleAdsConversion(consultationBooking ? 'consultation' : 'enquiry', conversionEventId);
        if (typeof window.fbq === 'function') {
          window.fbq('track', consultationBooking ? 'Schedule' : 'Lead', {
            content_name: formContext(),
            content_category: consultationBooking ? 'Consultation' : 'Website enquiry',
          }, { eventID: conversionEventId });
        }
      }
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

  /* The open drawer is an opaque full-screen overlay, so the page behind it has to
     leave the tab order too. `inert` is the cheapest way to do that in current
     browsers. We record the exact nodes we marked, and clear that same list on
     close, so a node that was already inert for another reason is left alone and
     nothing can be stranded inert if the DOM changes between open and close.
     Every close path below calls clearNavInert(): the toggle, a link click inside
     the drawer, Escape (which routes through the toggle) and the resize handler. */
  const navInertSelectors = ['#main-content', '.site-footer', '[data-legend-assistant]'];
  let navInertNodes = [];

  const clearNavInert = () => {
    navInertNodes.forEach((node) => {
      node.removeAttribute('inert');
    });
    navInertNodes = [];
  };

  const applyNavInert = () => {
    clearNavInert();
    navInertNodes = navInertSelectors
      .map((selector) => document.querySelector(selector))
      .filter((node) => (
        node
        && !node.hasAttribute('inert')
        && !node.contains(siteHeader)
        && !siteHeader.contains(node)
      ));
    navInertNodes.forEach((node) => {
      node.setAttribute('inert', '');
    });
  };

  const focusFirstInMobileNav = () => {
    if (!mobileNav) return;
    const focusable = [...mobileNav.querySelectorAll(
      'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
    )].find((node) => node.getClientRects().length > 0);
    focusable?.focus();
  };

  const restoreNavToggleFocus = () => {
    /* Only pull focus back if it is still inside the header, so closing the drawer
       never yanks focus away from wherever the user has since put it. */
    const active = document.activeElement;
    if (!active || !siteHeader.contains(active)) return;
    navToggle.focus();
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

    if (isOpen) {
      applyNavInert();
      focusFirstInMobileNav();
    } else {
      closeMobileAccordion();
      clearNavInert();
      restoreNavToggleFocus();
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
      /* Focus is deliberately left on the link the user just activated rather than
         sent back to the toggle: these include same-page anchors, and pulling focus
         to the header would scroll them straight back off their target. */
      clearNavInert();
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
    clearNavInert();
    restoreNavToggleFocus();
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
  /* House first, Legend second. Owner, 2026-08-06: the house is the real-world
     view somebody came to judge glass against, and Legend is the close-up you
     click through to — it was the other way round. The toggle label already names
     the scene you are switching TO, so it reads correctly from either start. */
  const backgroundNames = ['house', 'cat'];
  let backgroundIndex = 0;

  if (!stage || !viewport || !buttons.length) return;

  const setSplit = (value) => {
    const split = clamp(Number.parseFloat(value), 0, 100);
    viewport.style.setProperty('--split', `${split.toFixed(1)}%`);
  };

  /* ------------------------------------------------------------------ *
   *  OBSCURED GLASS OPTICS
   *
   *  Reference: the red-clock series at pallotglass.com, one photograph
   *  per pattern of the SAME clock through each glass. Read those before
   *  changing anything here; five earlier rebuilds failed by working from
   *  the brochure's product shots alone.
   *
   *  WHAT THOSE PHOTOGRAPHS ACTUALLY SHOW, and it is the opposite of the
   *  obvious guess: NOTHING IS BLURRED. Through Reeded the clock numerals
   *  stay razor sharp -- and repeat, because each rib is a cylindrical
   *  lens sampling a wide overlapping slice. Through Digital the face
   *  breaks into hard rectangles, each sharp. Through Cassini each petal
   *  is a crisp-edged lens holding a smooth tonal gradient. Obscuration
   *  comes from DISPLACEMENT AND FRAGMENTATION, not from diffusion, and
   *  the pattern's own relief sits over it bright and high-contrast.
   *
   *  So this samples the scene SHARPLY at remapped coordinates and then
   *  embosses the texture's own structure on top. An earlier version
   *  derived soft physics and discarded the texture's structure; every
   *  glass came out a milky wash and the owner was right that the plain
   *  CSS multiply beat it. Blur belongs only to `frost`, the one family
   *  that genuinely diffuses.
   * ------------------------------------------------------------------ */
  const glassLayer = stage.querySelector('[data-fg-obscure-glass-layer]');

  /* Per glass, from its own red-clock photograph. `kind` is the optics,
     not a strength band -- a rib cannot be expressed as a strong dapple. */
  const GLASS_MATERIALS = {
    /* ---- rib: periodic cylindrical lenses -------------------------------
       `spread` > 1 makes each rib image a swath wider than itself, so
       neighbours overlap and detail repeats; `flip` inverts inside the rib,
       which is what makes the reference read "12 | 21 | 2". */

    /* Reeded: machined flutes, ~10mm, dead regular, dead vertical. Sharpest
       glass in the range -- the clock numerals survive intact inside a flute
       and are destroyed only by being cut, compressed and reversed. Privacy 2
       comes entirely from that shredding, so the veil is near zero. */
    reeded: { texSize: 'cover', kind: 'rib', period: 34, spread: 4.2, flip: true, wander: 1.2, emboss: 0.34, veil: 0.02 },

    /* Charcoal Sticks: drawn vertical sticks of UNEVEN width, not flutes. Its
       reference shreds horizontal edges into vertical runs, so the per-stick
       vertical carry is the mechanism and the horizontal lensing is secondary. */
    'charcoal-sticks': { kind: 'rib', period: 17, spread: 2.0, wander: 3.5, jitter: 26, emboss: 0.55, veil: 0.05 },

    /* Cotswold: fine bark striation, far denser than Charcoal Sticks and with
       no vertical carry -- that is what separates the two vertical glasses. */
    cotswold: { kind: 'rib', period: 8, spread: 2.4, flip: true, wander: 2.2, jitter: 5, emboss: 0.42, veil: 0.1 },

    /* ---- cell: rigid rectangles, sharp inside, displaced as blocks ------ */
    /* Digital: the reference staircases the clock rim outward, so displacement
       must be of order a whole tile, and every tile is bevelled. */
    /* ---- OWNER-REVERTED, 2026-08-27. Digital, Chantilly, Oak and Sycamore
       were refined on an audit's advice -- relief cut, motif shrunk, scatter
       added -- and the owner judged all four WORSE and reverted them to these
       values. The audit's reasoning was that the pattern was being printed
       rather than refracted; on these four it was wrong, and the eye beat the
       measurement. Do not re-apply that change here without asking. ---- */
    digital: { kind: 'cell', cell: 13, jitter: 16, emboss: 0.5, veil: 0.05 },

    /* ---- hatchlens: two textures at two scales -------------------------- */
    /* Cassini: fine directional hatch, angle varying patch to patch, with
       smooth petal lenses over it. Faces average what they magnify to nearly
       one tone; the hatched ground stays sharp and is combed. */
    cassini: { texSize: 'cover',
      kind: 'hatchlens', heightBlur: 9, strength: 16, emboss: 0.34,
      hatch: 3.4, hatchEmboss: 0.55, petalLift: 0.4, faceBlur: 11, veil: 0.05,
    },
    /* Florielle: same construction, finer hatch, and the dimples displace
       harder so window frames dissolve rather than being outlined. */
    florielle: {
      kind: 'hatchlens', heightBlur: 6, strength: 20, emboss: 0.38,
      hatch: 2.2, hatchEmboss: 0.5, petalLift: 0.5, faceBlur: 7, veil: 0.07,
    },

    /* ---- emboss: the motif is the subject, scene legible between --------
       Every one of these had its relief cut and its refraction raised: the
       audit's repeated finding was that the pattern was being PRINTED over a
       sharp photograph instead of bending it. */

    /* Mayflower: ~40 hairline radial ridges per flower, not a dozen fat lobes.
       `scale` shrinks the motif so the flower count matches the reference. */
    mayflower: { kind: 'emboss', heightBlur: 3, strength: 26, emboss: 0.5, scale: 0.42, veil: 0.12 },
    chantilly: { kind: 'emboss', heightBlur: 4, strength: 7, emboss: 0.72, veil: 0.03 },
    /* Oak: felt in the shredding, not seen as outlines -- fine anisotropic
       streak, relief contrast cut hard. */
    oak: { kind: 'emboss', heightBlur: 6, strength: 8, emboss: 0.62, veil: 0.03 },
    /* Autumn is Oak's family, not Minster's -- owner, and the source bears it
       out: its fine-detail to broad-relief ratio is 2.05 against Oak's 2.94,
       where Minster sits at 0.84. It is a DRAWN plate. Bold embossed leaves
       with fine radial striations inside each one, so the relief leads and the
       scene behind stays largely where it is. It had been given Minster's
       wobble-led settings -- strength 22 against a relief of 0.4 -- which is
       exactly the effect the owner recognised. Now inverted to match Oak:
       relief up, displacement right down. Bolder than Oak because the plate
       is bolder, and no `scale`, because its motifs really are the larger. */
    autumn: { kind: 'emboss', heightBlur: 5, strength: 9, emboss: 0.68, veil: 0.04 },
    /* Sycamore: the fine engraved fan. Half Autumn's scale, gentler carry. */
    sycamore: { kind: 'emboss', heightBlur: 4, strength: 8, emboss: 0.6, veil: 0.03 },
    /* Tribal: the lattice is the only sharp thing; everything behind it is
       scattered to colour blobs. */
    tribal: { kind: 'emboss', heightBlur: 5, strength: 20, emboss: 0.55, softBlur: 5, veil: 0.16 },

    /* ---- dapple: irregular rolled relief, sharp but wandering ----------- */
    /* Minster and Arctic collided badly, so they are separated at the
       mechanism: Minster is a broad soft cathedral roll with low relief;
       Arctic is small hammered facets with hard bright rims. */
    minster: { texSize: 'cover', kind: 'dapple', heightBlur: 13, strength: 30, emboss: 0.22, veil: 0.08 },
    arctic: { kind: 'dapple', heightBlur: 2, strength: 16, emboss: 0.6, veil: 0.1 },
    /* Contora: tight worm field, displaced by about one worm width. */
    contora: { kind: 'dapple', heightBlur: 3, strength: 20, emboss: 0.38, softBlur: 2, veil: 0.1 },
    /* Everglade: deep 70s swirl, the largest drag in the dapple family. */
    everglade: { kind: 'dapple', heightBlur: 8, strength: 34, emboss: 0.45, veil: 0.14 },
    /* Taffeta: broad silk folds, glossy, gentle. */
    taffeta: { kind: 'dapple', heightBlur: 12, strength: 24, emboss: 0.34, veil: 0.06 },
    /* Warwick: privacy 1. The teapot stays fully legible through the real
       thing; only faint blown streaks disturb it. */
    warwick: { kind: 'dapple', heightBlur: 14, strength: 6, emboss: 0.14, veil: 0.01 },

    /* ---- frost: the only family that genuinely diffuses ----------------- */
    /* Stippolyte: dense fine stipple. Granular, not smooth -- the grain is
       what separates it from Satin. */
    stippolyte: { texSize: 'cover', kind: 'frost', blur: 8, grain: 26, emboss: 0.42, veil: 0.14 },
    /* Pelerine: feather filaments over a diffusing ground; ridges resample
       far enough to take colour from elsewhere. */
    pelerine: { kind: 'frost', blur: 5, grain: 12, strength: 14, heightBlur: 4, emboss: 0.4, veil: 0.1 },

    satin: { kind: 'css' },
  };;

  let renderToken = 0;
  let glassCanvas = null;

  const glassImage = (src) => new Promise((resolve, reject) => {
    const img = new Image();
    img.decoding = 'async';
    img.onload = () => resolve(img);
    img.onerror = reject;
    img.src = src;
  });

  const drawCover = (ctx, img, w, h, mode) => {
    if (mode === 'contain') {
      ctx.fillStyle = '#cddadb';
      ctx.fillRect(0, 0, w, h);
      const s = Math.min(w / img.naturalWidth, h / img.naturalHeight);
      ctx.drawImage(img, (w - img.naturalWidth * s) / 2, (h - img.naturalHeight * s) / 2,
        img.naturalWidth * s, img.naturalHeight * s);
      return;
    }
    const s = Math.max(w / img.naturalWidth, h / img.naturalHeight);
    ctx.drawImage(img, (w - img.naturalWidth * s) / 2, (h - img.naturalHeight * s) / 2,
      img.naturalWidth * s, img.naturalHeight * s);
  };

  const layTexture = (ctx, img, w, h, size, scale) => {
    const pin = /^([0-9.]+)px/.exec(size || '');
    if (!pin) {
      if (scale && scale !== 1) {
        /* Motif scale, per glass. Mayflower's flower had to shrink to about a
           third before its count matched the reference; a cover-laid texture
           has no other way to change its motif size. Tiled through the same
           non-periodic path so shrinking cannot introduce a visible repeat. */
        layTexture(ctx, img, w, h, `${Math.round(w * scale)}px auto`);
        return;
      }
      drawCover(ctx, img, w, h, 'cover');
      return;
    }
    /* NON-PERIODIC TILING. Mirror-bricking kept the sheet seamless but every
       tile still carried IDENTICAL content, so the eye finds the repeat -- the
       giveaway that this is a small texture copied across a window rather than
       one continuous sheet. Each tile now draws a DIFFERENT sub-region of the
       source photograph at the SAME scale: the crop window is a fixed fraction
       of the source, so only its offset varies. Pattern character and period
       survive; no two tiles are the same. Mirroring stays on alternate columns
       and rows so the joins do not step. */
    const frac = 0.72;
    const srcW = img.naturalWidth * frac;
    const srcH = img.naturalHeight * frac;
    const tw = Math.max(1, Math.round(parseFloat(pin[1]) * frac));
    const th = /100%$/.test(size) ? h : Math.max(1, Math.round(srcH * tw / srcW));
    const roam = (n) => {
      const v = Math.sin(n * 91.7) * 43758.5453;
      return v - Math.floor(v);
    };
    for (let cx = 0, rx = 0; cx < w + tw; cx += tw, rx += 1) {
      const drop = ((rx % 3) - 1) * (th / 3);
      for (let cy = -th + drop, ry = 0; cy < h + th; cy += th, ry += 1) {
        const sx0 = roam(rx * 7.3 + ry * 3.1) * (img.naturalWidth - srcW);
        const sy0 = roam(rx * 2.9 + ry * 11.7 + 5) * (img.naturalHeight - srcH);
        ctx.save();
        ctx.translate(rx % 2 ? cx + tw : cx, ry % 2 ? cy + th : cy);
        ctx.scale(rx % 2 ? -1 : 1, ry % 2 ? -1 : 1);
        ctx.drawImage(img, sx0, sy0, srcW, srcH, 0, 0, tw, th);
        ctx.restore();
      }
    }
  };

  const lumaOf = (ctx, w, h) => {
    const src = ctx.getImageData(0, 0, w, h).data;
    const out = new Float32Array(w * h);
    for (let i = 0, j = 0; i < out.length; i += 1, j += 4) {
      out[i] = src[j] * 0.299 + src[j + 1] * 0.587 + src[j + 2] * 0.114;
    }
    return out;
  };

  const boxBlurField = (field, w, h, r) => {
    const tmp = new Float32Array(field.length);
    const span = r * 2 + 1;
    for (let y = 0; y < h; y += 1) {
      const row = y * w;
      let acc = 0;
      for (let k = -r; k <= r; k += 1) acc += field[row + Math.min(w - 1, Math.max(0, k))];
      for (let x = 0; x < w; x += 1) {
        tmp[row + x] = acc / span;
        acc += field[row + Math.min(w - 1, x + r + 1)] - field[row + Math.max(0, x - r)];
      }
    }
    for (let x = 0; x < w; x += 1) {
      let acc = 0;
      for (let k = -r; k <= r; k += 1) acc += tmp[Math.min(h - 1, Math.max(0, k)) * w + x];
      for (let y = 0; y < h; y += 1) {
        field[y * w + x] = acc / span;
        acc += tmp[Math.min(h - 1, y + r + 1) * w + x] - tmp[Math.max(0, y - r) * w + x];
      }
    }
  };

  const renderGlass = async () => {
    if (!glassLayer) return;
    const button = buttons.find((o) => o.classList.contains('is-active')) || buttons[0];
    const key = button?.dataset.key || '';
    const mat = GLASS_MATERIALS[key];
    const textureUrl = /url\("?([^")]+)"?\)/.exec(button?.dataset.texture || '');

    if (!mat || mat.kind === 'css' || !textureUrl) {
      stage.dataset.glassRender = 'css';
      return;
    }

    const token = renderToken += 1;
    const background = stage.dataset.activeBackground === 'cat' ? 'cat' : 'house';
    const sceneUrl = background === 'cat' ? stage.dataset.catImage : stage.dataset.houseImage;
    if (!sceneUrl) {
      stage.dataset.glassRender = 'css';
      return;
    }

    try {
      const rect = stage.querySelector('.fg-obscure-stage__viewport')?.getBoundingClientRect();
      const w = Math.max(320, Math.min(900, Math.round(rect?.width || 900)));
      const h = Math.max(240, Math.min(675, Math.round(rect?.height || 675)));
      const [sceneImg, texImg] = await Promise.all([glassImage(sceneUrl), glassImage(textureUrl[1])]);
      if (token !== renderToken) return;

      const make = () => {
        const c = document.createElement('canvas');
        c.width = w;
        c.height = h;
        return c.getContext('2d', { willReadFrequently: true });
      };

      const sceneCtx = make();
      drawCover(sceneCtx, sceneImg, w, h, background === 'cat' ? 'contain' : 'cover');
      const scene = sceneCtx.getImageData(0, 0, w, h).data;

      /* Only frost gets a diffused copy. Everything else samples sharp. */
      /* A locally averaged copy. A lens face averages what it magnifies down
         to nearly one tone -- in the clock photograph each Cassini petal is a
         flat wash, not a legible little picture -- and that averaging is what
         actually obscures. The hatched GROUND between the petals stays sharp
         and is combed instead. Getting these the wrong way round is what left
         the scene readable through a privacy 5 glass. */
      let flat = null;
      if (mat.kind === 'hatchlens') {
        const flatCtx = make();
        flatCtx.filter = `blur(${mat.faceBlur || 9}px)`;
        flatCtx.drawImage(sceneCtx.canvas, 0, 0);
        flat = flatCtx.getImageData(0, 0, w, h).data;
      }

      let scatter = null;
      if (mat.softBlur) {
        const scCtx = make();
        scCtx.filter = `blur(${mat.softBlur}px)`;
        scCtx.drawImage(sceneCtx.canvas, 0, 0);
        scatter = scCtx.getImageData(0, 0, w, h).data;
      }

      let soft = null;
      if (mat.kind === 'frost') {
        const softCtx = make();
        softCtx.filter = `blur(${mat.blur}px)`;
        softCtx.drawImage(sceneCtx.canvas, 0, 0);
        soft = softCtx.getImageData(0, 0, w, h).data;
      }

      const texCtx = make();
      texCtx.fillStyle = '#808080';
      texCtx.fillRect(0, 0, w, h);
      /* `texSize` lets a material override the data's CSS pin. Four textures
         carry a pin for the CSS stage -- and a pin means tiling, which means
         tile edges. Measured over a flat field, Cassini's tile boundary showed
         as a 52.9 row-step against 6-8 for every other glass: a visible seam
         across the sheet. None of the four needs the pin here, because a
         material's scale now comes from its own geometry (`period`, `cell`,
         `scale`) rather than from the texture's CSS size, so they lay at
         `cover` and tile exactly once. No tiling, no seam, nothing to hide. */
      layTexture(texCtx, texImg, w, h, mat.texSize || button.dataset.size || 'cover', mat.scale);
      const T = lumaOf(texCtx, w, h);

      /* Flat-field: several sources are lit from one side, and any
         threshold or gradient on the raw photograph inherits that as a
         phantom tilt across the pane. */
      const broad = Float32Array.from(T);
      boxBlurField(broad, w, h, 26);
      for (let i = 0; i < T.length; i += 1) T[i] = T[i] - broad[i] + 128;

      /* The relief that steers refraction, smoothed in float so 8-bit
         steps cannot draw contour rings. */
      const H = Float32Array.from(T);
      const hb = Math.max(1, Math.round(mat.heightBlur || 4));
      boxBlurField(H, w, h, hb);
      boxBlurField(H, w, h, hb);

      let gNorm = 1;
      if (mat.strength) {
        const mags = [];
        for (let k = 0; k < 4096; k += 1) {
          const px = (997 * k) % (w * h);
          const x = px % w;
          const y = (px - x) / w;
          if (x < 2 || y < 2 || x >= w - 2 || y >= h - 2) continue;
          mags.push(Math.hypot(H[px + 2] - H[px - 2], H[px + 2 * w] - H[px - 2 * w]));
        }
        mags.sort((a, b) => a - b);
        gNorm = Math.max(mags[Math.floor(mags.length * 0.99)] || 1, 1e-3);
      }

      /* The emboss layer: the texture's own high-frequency structure, the
         thing the CSS multiply got right and the soft renderer lost. */
      const detail = new Float32Array(T.length);
      for (let i = 0; i < T.length; i += 1) detail[i] = T[i] - H[i];
      const dSample = [];
      for (let k = 0; k < 4096; k += 1) dSample.push(Math.abs(detail[(1499 * k) % detail.length]));
      dSample.sort((a, b) => a - b);
      const dNorm = Math.max(dSample[Math.floor(dSample.length * 0.92)] || 1, 1e-3);

      /* Local line orientation of the fine texture, via a structure tensor.
         Cassini's hatch runs at a different angle in every patch, and the
         source photograph already carries that -- so the angle is measured
         from the texture rather than invented, and the patchwork comes out
         for free. Blurred tensor components, so the angle varies slowly
         across a patch instead of flickering per pixel. */
      let hatchPX = null;
      let hatchPY = null;
      let petal = null;
      if (mat.kind === 'hatchlens') {
        const jxx = new Float32Array(T.length);
        const jyy = new Float32Array(T.length);
        const jxy = new Float32Array(T.length);
        for (let y = 1; y < h - 1; y += 1) {
          for (let x = 1; x < w - 1; x += 1) {
            const i = y * w + x;
            const dx = detail[i + 1] - detail[i - 1];
            const dy = detail[i + w] - detail[i - w];
            jxx[i] = dx * dx;
            jyy[i] = dy * dy;
            jxy[i] = dx * dy;
          }
        }
        boxBlurField(jxx, w, h, 7);
        boxBlurField(jyy, w, h, 7);
        boxBlurField(jxy, w, h, 7);
        hatchPX = new Float32Array(T.length);
        hatchPY = new Float32Array(T.length);
        for (let i = 0; i < T.length; i += 1) {
          /* Dominant gradient direction; the LINES run perpendicular to it,
             and light combs perpendicular to the lines -- i.e. back along
             the gradient. */
          const theta = 0.5 * Math.atan2(2 * jxy[i], jxx[i] - jyy[i] + 1e-6);
          hatchPX[i] = Math.cos(theta);
          hatchPY[i] = Math.sin(theta);
        }
        /* The petal mask: smooth bright regions are the lens faces, and
           they carry no hatch. Percentile bounds so exposure cannot move
           the split. */
        const sm = Float32Array.from(T);
        boxBlurField(sm, w, h, 4);
        const ps = [];
        for (let k = 0; k < 4096; k += 1) ps.push(sm[(2003 * k) % sm.length]);
        ps.sort((a, b) => a - b);
        const lo = ps[Math.floor(ps.length * 0.5)];
        const hi = ps[Math.floor(ps.length * 0.78)];
        petal = new Float32Array(T.length);
        for (let i = 0; i < T.length; i += 1) {
          let v = (sm[i] - lo) / Math.max(hi - lo, 1e-3);
          petal[i] = v < 0 ? 0 : v > 1 ? 1 : v;
        }
      }

      const out = sceneCtx.createImageData(w, h);
      const dst = out.data;
      const period = Math.max(4, mat.period || 20);
      const spread = mat.spread || 1;
      const cell = Math.max(4, mat.cell || 12);
      const jitter = mat.jitter || 0;
      const embossAmp = mat.emboss || 0;
      const veil = mat.veil || 0;
      const groundAmp = mat.ground || 0;
      const grainAmp = mat.grain || 0;

      const ribWander = mat.wander || 0;
      const ribDrift = (x) => (ribWander
        ? Math.sin(x * 0.0037) * ribWander + Math.sin(x * 0.011 + 1.7) * ribWander * 0.5
        : 0);

      const hash = (a, b) => {
        const n = Math.sin(a * 127.1 + b * 311.7) * 43758.5453;
        return n - Math.floor(n);
      };

      for (let y = 0; y < h; y += 1) {
        for (let x = 0; x < w; x += 1) {
          const i = y * w + x;
          let sx = x;
          let sy = y;

          if (mat.kind === 'rib') {
            /* Cylindrical lens. Each rib compresses a slice `spread` times its
               own width, so neighbours overlap and detail repeats -- the clock
               numerals appearing three times across three ribs.

               AND IT INVERTS. A convex cylinder flips what it images, which is
               why the reference reads "12 | 21 | 2" rather than three identical
               copies. `flip` runs the sample backwards inside the rib, and it
               is the single detail separating a real flute from a stripe.

               `wander` drifts the rib phase slowly across the pane: drawn glass
               is regular but not machined, and without it every flute lands on
               an exact multiple and reads as a generated grating. */
            const xd = x + ribDrift(x);
            const idx = Math.floor(xd / period);
            const u = xd / period - idx;
            const centre = (idx + 0.5) * period;
            const t = mat.flip ? (0.5 - u) : (u - 0.5);
            sx = centre + t * period * spread;
            if (jitter) {
              /* A drawn stick is not a machined flute: each carries the scene
                 down its own length by a different amount, which is what
                 shreds horizontal edges into vertical runs. */
              sy = y + (hash(idx, 0) - 0.5) * jitter;
              sx += (hash(idx, 7) - 0.5) * period * 0.5;
            }
          } else if (mat.kind === 'cell') {
            const cxi = Math.floor(x / cell);
            const cyi = Math.floor(y / cell);
            sx = x + (hash(cxi, cyi) - 0.5) * jitter;
            sy = y + (hash(cxi + 31, cyi + 17) - 0.5) * jitter;
          } else if (mat.kind === 'hatchlens') {
            const xm = x > 1 ? i - 2 : i;
            const xp = x < w - 2 ? i + 2 : i;
            const ym = y > 1 ? i - 2 * w : i;
            const yp = y < h - 2 ? i + 2 * w : i;
            let gx = (H[xp] - H[xm]) / gNorm;
            let gy = (H[yp] - H[ym]) / gNorm;
            gx /= 1 + Math.abs(gx) * 0.4;
            gy /= 1 + Math.abs(gy) * 0.4;
            /* A petal is a smooth lens: it bends more and combs not at all.
               The ground is hatched: it barely bends but combs hard, at the
               hatch's own frequency and along its own local angle. */
            const f = petal[i];
            const lens = mat.strength * (0.45 + f * mat.petalLift);
            sx = x + gx * lens;
            sy = y + gy * lens;
            const comb = (detail[i] / dNorm) * mat.hatch * (1 - f * 0.85);
            sx += hatchPX[i] * comb;
            sy += hatchPY[i] * comb;
          } else if (mat.strength) {
            const xm = x > 1 ? i - 2 : i;
            const xp = x < w - 2 ? i + 2 : i;
            const ym = y > 1 ? i - 2 * w : i;
            const yp = y < h - 2 ? i + 2 * w : i;
            let gx = (H[xp] - H[xm]) / gNorm;
            let gy = (H[yp] - H[ym]) / gNorm;
            gx /= 1 + Math.abs(gx) * 0.4;
            gy /= 1 + Math.abs(gy) * 0.4;
            sx = x + gx * mat.strength;
            sy = y + gy * mat.strength;
          }

          if (grainAmp) {
            sx += (hash(x, y) - 0.5) * grainAmp;
            sy += (hash(x + 9, y + 3) - 0.5) * grainAmp;
          }

          sx = Math.min(w - 1.001, Math.max(0, sx));
          sy = Math.min(h - 1.001, Math.max(0, sy));

          const x0 = sx | 0;
          const y0 = sy | 0;
          const fx = sx - x0;
          const fy = sy - y0;
          const p00 = (y0 * w + x0) * 4;
          const p10 = p00 + 4;
          const p01 = p00 + w * 4;
          const p11 = p01 + 4;
          const w00 = (1 - fx) * (1 - fy);
          const w10 = fx * (1 - fy);
          const w01 = (1 - fx) * fy;
          const w11 = fx * fy;

          /* Signed emboss: ridges catch light, grooves shade. Clamped, so
             the pattern is bold without ever going to paint. */
          let e = detail[i] / dNorm;
          if (e > 1) e = 1; else if (e < -1) e = -1;
          if (mat.kind === 'hatchlens') {
            /* The hatch draws itself on the ground and fades on the petal
               faces, which is exactly how the two read in the photograph. */
            e *= embossAmp + (mat.hatchEmboss - embossAmp) * (1 - petal[i]);
          } else {
            e *= embossAmp;
          }

          /* Digital's tiles are bevelled: a bright specular edge on two sides,
             a shadow on the others. Without it the mosaic reads as a change of
             infill rather than as relief cut into the glass. */
          let rim = 0;
          if (mat.kind === 'cell' && mat.rim) {
            const ux = x - Math.floor(x / cell) * cell;
            const uy = y - Math.floor(y / cell) * cell;
            if (ux < 1 || uy < 1) rim = mat.rim;
            else if (ux > cell - 2 || uy > cell - 2) rim = -mat.rim * 0.7;
          }

          const o = i * 4;
          const faceMix = mat.kind === 'hatchlens' ? petal[i] : 0;
          for (let ch = 0; ch < 3; ch += 1) {
            const src = mat.kind === 'frost' ? soft : scene;
            let v = src[p00 + ch] * w00 + src[p10 + ch] * w10 + src[p01 + ch] * w01 + src[p11 + ch] * w11;
            if (scatter) {
              const sc = scatter[p00 + ch] * w00 + scatter[p10 + ch] * w10
                + scatter[p01 + ch] * w01 + scatter[p11 + ch] * w11;
              v += (sc - v) * 0.75;
            }
            if (faceMix) {
              const f = flat[p00 + ch] * w00 + flat[p10 + ch] * w10 + flat[p01 + ch] * w01 + flat[p11 + ch] * w11;
              v += (f - v) * faceMix;
            }
            if (groundAmp) {
              /* The fine screened ground between lens elements: colour
                 passes, detail does not. */
              const g = (1 - Math.min(1, Math.abs(detail[i]) / dNorm)) * groundAmp;
              v += (240 - v) * g * 0.35;
            }
            /* Moulded relief SCATTERS ambient light, so it always reads
               lighter than what is behind it -- bright motifs even over a dark
               object. A symmetric signed emboss printed black strokes over
               foliage and read as a decal; the negative lobe is therefore
               heavily damped rather than mirrored. */
            v += e > 0 ? (255 - v) * e : v * e * 0.35;
            if (rim) v += rim > 0 ? (255 - v) * rim : v * rim;
            if (veil) v += (250 - v) * veil;
            dst[o + ch] = v;
          }
          dst[o + 3] = 255;
        }
      }

      if (token !== renderToken) return;
      if (!glassCanvas) {
        glassCanvas = document.createElement('canvas');
        glassCanvas.className = 'fg-obscure-stage__optics';
        glassCanvas.setAttribute('aria-hidden', 'true');
        glassLayer.appendChild(glassCanvas);
      }
      glassCanvas.width = w;
      glassCanvas.height = h;
      glassCanvas.getContext('2d').putImageData(out, 0, 0);
      stage.dataset.glassRender = 'canvas';
    } catch (error) {
      stage.dataset.glassRender = 'css';
    }
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
    renderGlass();
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
      /* Photographed patterns carry their own scale; a gradient does not need one.
         Without this the stage kept whichever size the previous pattern set, so
         switching from Reeded to anything else left the new texture pinned at
         Reeded's 274px. */
      stage.style.setProperty('--active-texture-size', button.dataset.size || 'cover');
    }

    stage.style.setProperty('--privacy', privacy);
    stage.dataset.activeGlass = key;
    renderGlass();
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

  renderGlass();

  splitControl?.addEventListener('input', () => {
    setSplit(splitControl.value);
  });

  /* Dragging, rather than tapping a position.
     The divider is an `<input type="range">` stretched invisibly across the whole
     stage. On iOS that only drags when the touch starts on the thumb; a touch
     anywhere else jumps the value once and then does nothing, which is exactly
     the "you have to click the position" the owner reported.

     So the gesture is handled here, and the input keeps its value in sync for
     keyboard and assistive tech. The stage keeps `touch-action: pan-y`, so a
     vertical drag still scrolls the page: only horizontal movement is claimed,
     and only once it clearly beats the vertical, so a scroll that happens to
     start on the visualiser is not stolen from the reader. */
  const splitFromEvent = (event) => {
    const rect = viewport.getBoundingClientRect();
    if (!rect.width) return null;
    return clamp(((event.clientX - rect.left) / rect.width) * 100, 0, 100);
  };

  const applySplit = (value) => {
    setSplit(value);
    if (splitControl) splitControl.value = String(Math.round(value));
  };

  let dragId = null;
  let dragStart = null;
  let dragLocked = false;

  viewport.addEventListener('pointerdown', (event) => {
    if (event.pointerType === 'mouse' && event.button !== 0) return;
    dragId = event.pointerId;
    dragStart = { x: event.clientX, y: event.clientY };
    // A mouse press is unambiguous and grabs at once. A touch has to prove it is
    // horizontal first, or vertical scrolling breaks.
    dragLocked = event.pointerType === 'mouse';
    if (dragLocked) {
      const value = splitFromEvent(event);
      if (value !== null) applySplit(value);
    }
  });

  viewport.addEventListener('pointermove', (event) => {
    if (dragId !== event.pointerId || !dragStart) return;

    if (!dragLocked) {
      const dx = Math.abs(event.clientX - dragStart.x);
      const dy = Math.abs(event.clientY - dragStart.y);
      if (dx < 6 || dx <= dy) return;
      dragLocked = true;
      if (viewport.setPointerCapture) viewport.setPointerCapture(event.pointerId);
    }

    const value = splitFromEvent(event);
    if (value === null) return;
    if (event.cancelable) event.preventDefault();
    applySplit(value);
  });

  const endDrag = (event) => {
    if (dragId !== event.pointerId) return;
    // A tap that never became a drag still positions the divider, which is what
    // the page already did and is worth keeping.
    if (!dragLocked && dragStart) {
      const value = splitFromEvent(event);
      if (value !== null) applySplit(value);
    }
    dragId = null;
    dragStart = null;
    dragLocked = false;
  };

  viewport.addEventListener('pointerup', endDrag);
  viewport.addEventListener('pointercancel', endDrag);

  backgroundToggle?.addEventListener('click', () => {
    backgroundIndex = (backgroundIndex + 1) % backgroundNames.length;
    activateBackground(backgroundNames[backgroundIndex]);
  });

  activateBackground(backgroundNames[backgroundIndex]);
  setSplit(splitControl?.value || 54);
});

/* Notan magnetic integral blind visualiser.
 *
 * Draws one glazed unit face on and fully straight, with the blind rendered
 * from its geometry rather than from photography. Face on is what makes a 2D
 * canvas sufficient: with no perspective a slat projects to a plain rectangle
 * of height `slat * |sin phi| + thickness * |cos phi|`, which is exact. Nine
 * colours against a continuous tilt and a continuous lift is also far past
 * what a sprite sheet can hold, so it has to be drawn.
 *
 * Two caches carry the cost. The garden behind the glass is rendered small,
 * blown back up to soften it, and kept until the box resizes. The blind is one
 * tile, being a slat and the gap under it, rebuilt only when the tilt, the
 * colour or the size actually change and then stamped once per slat. A frame
 * that only moves the lift therefore reuses the tile it already had.
 */
document.querySelectorAll('[data-fg-blind-visualiser]').forEach((root) => {
  const canvas = root.querySelector('[data-fg-blind-canvas]');
  const stage = root.querySelector('.fg-blind-visualiser__stage');
  const tiltInput = root.querySelector('[data-fg-blind-tilt]');
  const liftInput = root.querySelector('[data-fg-blind-lift]');
  const readout = root.querySelector('[data-fg-blind-readout]');
  const colourButtons = [...root.querySelectorAll('[data-fg-blind-colour]')];

  if (!canvas || !stage || !tiltInput || !liftInput || !colourButtons.length) return;

  const ctx = canvas.getContext('2d', { alpha: false });
  if (!ctx) return;

  /* Millimetres. A window sash rather than a door leaf, because at door
     height the slats fall below two pixels each and the tilt stops reading. */
  const GLASS_W = 520;
  const GLASS_H = 700;
  const SLAT = 12.5;
  const SLAT_T = 0.18;
  const PITCH = 11.9;
  const STACK_PITCH = 2.15;
  const RAIL = 15;
  /* The Notan profile: the colour matched frame sealed inside the glass that
     the blind hangs in and that the two magnets run on. Notan describe it as a
     slim 30mm fully symmetrical profile, so it borders the glass on all four
     sides rather than only capping the head. */
  /* uPVC section, from the owner's photograph of the showroom unit: an outer
     frame face, a shadow groove, the sash face, a second groove, then the
     glazing bead. Anthracite, because that is the unit the reference shows and
     because the hardware inside the glass is matched to the frame rather than
     to the slats. */
  /* Slimmer than the showroom sample it was drawn from, deliberately. The
     blind's own cassette is fifty millimetres a side, and at the sample's full
     section the two borders together swallowed the glass. The window is the
     surround here; the blind unit is the subject. */
  const OUTER = 14;
  const GROOVE = 2;
  const SASH = 11;
  const BEAD = 6;
  const FRAME = OUTER + GROOVE + SASH + GROOVE + BEAD;
  const UPVC = { r: 56, g: 62, b: 66 };
  /* The warm edge spacer round the sealed unit, the blind's own head, and the
     rail the two magnets run on. The rail is slim and sits near the right of
     the glass; there is no wide colour matched border, which an earlier pass
     had wrongly drawn all the way round. */
  /* The blind's own framework inside the sealed unit. It is a U: two side
     members and a head, and nothing along the bottom, where the blind's bottom
     rail simply comes to rest on the edge of the glass. The magnets run on the
     right hand member and overhang it, which is what the reference photograph
     shows. Anthracite, matched to the window frame. */
  const CASSETTE = 50;
  const SPACER = 9;
  /* The cassette head is the head, so there is no separate rail band under it.
     Both are the slat colour now, and drawing two made one flat slab. */
  const HEADRAIL = 0;
  /* The slim rail at the inner edge of the frame, at the boundary with the
     clear, that the two magnets slot onto. */
  const RAIL_W = 11;
  /* The two are not the same size. On the real unit the lift magnet is
     noticeably longer than the tilt one, about half as long again, and both
     are wider than the earlier photographs suggested: those were shot at a
     steep angle, which foreshortens the width and not the length. */
  const MAGNET_W = 28;
  const MAGNET_H_TILT = 58;
  const MAGNET_H_LIFT = 95;
  const UNIT_W = GLASS_W + FRAME * 2;
  const UNIT_H = GLASS_H + FRAME * 2;
  const BLIND_W = GLASS_W - CASSETTE * 2;
  const BLIND_H = GLASS_H - CASSETTE - SPACER;
  const DROP = BLIND_H - HEADRAIL - RAIL;
  const SLAT_COUNT = Math.floor(DROP / PITCH);
  /* Real tilt mechanisms stop short of ninety degrees. Stopping at seventy
     eight also trims most of the dead zone at each end of the slider, where
     the slats have already overlapped and further rotation changes nothing. */
  const MAX_TILT = (78 * Math.PI) / 180;

  const smooth = (start, end, value) => {
    const amount = clamp((value - start) / (end - start || 0.0001));
    return amount * amount * (3 - 2 * amount);
  };
  const toRgb = (hex) => {
    const raw = String(hex || '').replace('#', '');
    const full = raw.length === 3 ? raw.split('').map((c) => c + c).join('') : raw;
    const n = Number.parseInt(full, 16);
    return Number.isFinite(n) ? { r: (n >> 16) & 255, g: (n >> 8) & 255, b: n & 255 } : { r: 255, g: 255, b: 255 };
  };
  const mixRgb = (a, b, t) => ({ r: a.r + (b.r - a.r) * t, g: a.g + (b.g - a.g) * t, b: a.b + (b.b - a.b) * t });
  const paint = (c, k, add = 0, alpha = 1) => `rgba(${clamp(Math.round(c.r * k + add), 0, 255)},${clamp(Math.round(c.g * k + add), 0, 255)},${clamp(Math.round(c.b * k + add), 0, 255)},${alpha})`;

  const swatches = colourButtons.map((button) => ({
    face: toRgb(button.dataset.hex),
    back: toRgb(button.dataset.reverse || button.dataset.hex),
    metallic: button.dataset.metallic === '1',
    glitter: button.dataset.glitter === '1',
    name: button.dataset.name || 'Slat colour',
    code: button.dataset.code || '',
  }));

  let activeIndex = Math.max(0, colourButtons.findIndex((button) => button.classList.contains('is-active')));
  let shownFace = { ...swatches[activeIndex].face };
  let shownBack = { ...swatches[activeIndex].back };
  let shownMetallic = swatches[activeIndex].metallic ? 1 : 0;
  let shownGlitter = swatches[activeIndex].glitter ? 1 : 0;

  let tiltTarget = Number.parseFloat(tiltInput.value);
  let liftTarget = Number.parseFloat(liftInput.value);
  let tilt = tiltTarget;
  let lift = liftTarget;

  let width = 0;
  let height = 0;
  let dpr = 1;
  let scene = null;
  let sceneKey = '';
  let tile = null;
  let tileKey = '';
  let unitChrome = null;
  let chromeKey = '';
  let grain = null;
  let frame = 0;
  let visible = true;
  let dragging = null;
  let focused = null;
  const grabs = new Map();
  root.querySelectorAll('[data-fg-blind-grab]').forEach((grab) => {
    grabs.set(grab.dataset.fgBlindGrab, grab);
  });
  const still = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* A hanging blind is not a grating. Real slats sit a fraction off pitch and
     catch fractionally different amounts of light, and without that the render
     reads as a printed pattern no matter how good the shading is. Computed
     once from the index rather than from Math.random, so a slat keeps the same
     character between frames instead of shimmering.

     The amounts applied at the draw site are deliberately small. The first
     pass was four times stronger and read as damage rather than as hang. It
     is a fine line: none at all is a printed rule, too much is a bent blind. */
  const wobble = Array.from({ length: SLAT_COUNT }, (unused, i) => {
    const n = Math.sin(i * 12.9898) * 43758.5453;
    const m = Math.sin(i * 78.233 + 1.7) * 12345.6789;
    const r = Math.sin(i * 39.4271 + 4.1) * 24634.6345;
    return {
      offset: (n - Math.floor(n)) - 0.5,
      gain: (m - Math.floor(m)) - 0.5,
      lean: (r - Math.floor(r)) - 0.5,
    };
  });

  /* The garden is drawn at an eighth of the size and scaled back up. That is the
     blur: it costs one upscale instead of a filter pass, it is supported
     everywhere, and the softness it produces is the depth of field a real
     camera focused on the blind would give the garden behind it anyway. */
  const buildScene = (w, h) => {
    const sw = Math.max(28, Math.round(w / 8));
    const sh = Math.max(28, Math.round(h / 8));
    const small = document.createElement('canvas');
    small.width = sw;
    small.height = sh;
    const g = small.getContext('2d');
    if (!g) return null;

    const sky = g.createLinearGradient(0, 0, 0, sh * 0.7);
    sky.addColorStop(0, '#bcdcf0');
    sky.addColorStop(0.5, '#e4f0f7');
    sky.addColorStop(1, '#f4f7ea');
    g.fillStyle = sky;
    g.fillRect(0, 0, sw, sh);

    const sun = g.createRadialGradient(sw * 0.74, sh * 0.08, 0, sw * 0.74, sh * 0.08, sw * 1.1);
    sun.addColorStop(0, 'rgba(255,254,246,1)');
    sun.addColorStop(0.4, 'rgba(255,252,238,0.5)');
    sun.addColorStop(1, 'rgba(255,252,238,0)');
    g.fillStyle = sun;
    g.fillRect(0, 0, sw, sh);

    const horizon = sh * 0.66;
    /* Three summed sines give a canopy that reads as trees without any of
       them being recognisable, which is the point once it is this soft. */
    g.beginPath();
    g.moveTo(0, sh);
    g.lineTo(0, horizon);
    for (let x = 0; x <= sw; x += 1) {
      const t = x / sw;
      const canopy = Math.sin(t * 8.3) * 0.5 + Math.sin(t * 19.7 + 1.3) * 0.3 + Math.sin(t * 37.1 + 2.6) * 0.17;
      g.lineTo(x, horizon - sh * 0.16 * (0.5 + canopy * 0.5));
    }
    g.lineTo(sw, sh);
    g.closePath();
    const trees = g.createLinearGradient(0, horizon - sh * 0.24, 0, horizon + sh * 0.02);
    trees.addColorStop(0, '#b6c99b');
    trees.addColorStop(0.55, '#96b177');
    trees.addColorStop(1, '#7b9761');
    g.fillStyle = trees;
    g.fill();

    const lawn = g.createLinearGradient(0, horizon, 0, sh);
    lawn.addColorStop(0, '#adc484');
    lawn.addColorStop(0.5, '#9cb673');
    lawn.addColorStop(1, '#87a25f');
    g.fillStyle = lawn;
    g.fillRect(0, horizon, sw, sh - horizon);

    const paving = g.createLinearGradient(0, sh * 0.88, 0, sh);
    paving.addColorStop(0, 'rgba(214,204,186,0)');
    paving.addColorStop(1, 'rgba(220,211,193,0.92)');
    g.fillStyle = paving;
    g.fillRect(0, sh * 0.88, sw, sh * 0.12);

    /* Dapple. At this blur nothing in a real garden survives as shape, but the
       uneven pools of light and shade do, and a smooth gradient without them
       is the tell that the view was generated rather than photographed. */
    const dapple = [
      [0.18, 0.78, 0.3, 'rgba(255,252,232,0.5)'], [0.62, 0.86, 0.34, 'rgba(72,92,54,0.34)'],
      [0.86, 0.72, 0.26, 'rgba(255,250,226,0.42)'], [0.34, 0.94, 0.24, 'rgba(84,104,62,0.3)'],
      [0.08, 0.62, 0.22, 'rgba(96,116,74,0.32)'], [0.5, 0.7, 0.2, 'rgba(255,253,238,0.34)'],
    ];
    dapple.forEach(([x, y, r, colour]) => {
      const pool = g.createRadialGradient(sw * x, sh * y, 0, sw * x, sh * y, sw * r);
      pool.addColorStop(0, colour);
      pool.addColorStop(1, colour.replace(/[\d.]+\)$/, '0)'));
      g.fillStyle = pool;
      g.fillRect(0, 0, sw, sh);
    });

    const render = (target, veil) => {
      const c = document.createElement('canvas');
      c.width = Math.max(1, Math.round(w));
      c.height = Math.max(1, Math.round(h));
      const f = c.getContext('2d');
      if (!f) return null;
      f.imageSmoothingEnabled = true;
      f.imageSmoothingQuality = 'high';
      f.drawImage(target, 0, 0, c.width, c.height);
      /* A camera exposed for the room blows the garden out. Without this veil
         the slats read as darker than the view rather than silhouetted by it. */
      f.fillStyle = `rgba(255,255,255,${veil})`;
      f.fillRect(0, 0, c.width, c.height);
      return c;
    };

    /* A second, far coarser copy of the same garden. Added back over the
       finished blind with `lighter`, it is the veiling glare a bright exterior
       throws across dark slats: light spilling out of the gaps and washing the
       aluminium next to them. It is the difference between a diagram of a
       blind and a photograph of one, and because it is the scene rather than a
       readback of the canvas it costs one cached drawImage rather than a
       getImageData every frame. */
    const hazeW = Math.max(8, Math.round(sw / 3));
    const hazeH = Math.max(8, Math.round(sh / 3));
    const haze = document.createElement('canvas');
    haze.width = hazeW;
    haze.height = hazeH;
    const hz = haze.getContext('2d');
    if (hz) {
      hz.imageSmoothingEnabled = true;
      hz.drawImage(small, 0, 0, hazeW, hazeH);
    }

    return { view: render(small, 0.14), haze: render(haze, 0.26) };
  };

  const buildGrain = () => {
    const size = 96;
    const c = document.createElement('canvas');
    c.width = size;
    c.height = size;
    const g = c.getContext('2d');
    if (!g) return null;
    const data = g.createImageData(size, size);
    for (let i = 0; i < data.data.length; i += 4) {
      const v = 118 + Math.random() * 24;
      data.data[i] = v;
      data.data[i + 1] = v;
      data.data[i + 2] = v;
      data.data[i + 3] = 255;
    }
    g.putImageData(data, 0, 0);
    return c;
  };

  /* One tile: the slat, then the gap beneath it, at three times the height so
     the fractional pitch lands with clean antialiasing when it is stamped. */
  const buildTile = (face, back, metallic, glitter, phi, pitchPx, slatPx) => {
    const ss = 3;
    /* A glitter finish needs a wide tile. The tile is stretched to the width of
       the blind, so on the usual 96 a one pixel fleck comes out as a four pixel
       horizontal smear, which reads as a scratch rather than a flake. */
    const W = glitter ? 480 : 96;
    const H = Math.max(3, Math.round(pitchPx * ss));
    const bandH = clamp(slatPx * ss, 0.5, H);
    const gapH = H - bandH;
    const openness = clamp((pitchPx - slatPx) / pitchPx, 0, 1);
    const c = document.createElement('canvas');
    c.width = W;
    c.height = H;
    const g = c.getContext('2d');
    if (!g) return null;

    if (gapH > 0.5) {
      /* The gap is not empty: the slat above shades the top of it and the
         slat below catches light at the bottom of it. Kept light on purpose.
         An earlier pass used nearly half black here and it read as a painted
         stripe, because in life the gap is the brightest thing on the window
         and the slat is what is dark. */
      const shadow = g.createLinearGradient(0, bandH, 0, H);
      shadow.addColorStop(0, 'rgba(24,26,22,0.24)');
      shadow.addColorStop(0.45, 'rgba(24,26,22,0.03)');
      shadow.addColorStop(1, 'rgba(24,26,22,0.14)');
      g.fillStyle = shadow;
      g.fillRect(0, bandH, W, gapH);

      /* On a two sided slat the outward face shows as a sliver through the
         gap, on whichever side the tilt turns it towards. Absent a reverse
         colour this paints the same colour it already is and disappears. */
      const reveal = clamp(Math.abs(Math.sin(phi)) * 0.85, 0, 1) * openness;
      const sliver = gapH * reveal * 0.5;
      if (sliver > 0.4) {
        const top = phi < 0;
        const y = top ? bandH : H - sliver;
        const edge = g.createLinearGradient(0, y, 0, y + sliver);
        edge.addColorStop(top ? 0 : 1, paint(back, 0.5, 0, 0.92));
        edge.addColorStop(top ? 1 : 0, paint(back, 0.72, 0, 0));
        g.fillStyle = edge;
        g.fillRect(0, y, W, sliver);
      }
    }

    /* The room side of a slat is always turned away from an exterior sun, so
       there is no direct term at all. What lights it is room ambient, which
       tracks how square the slat is to the room, plus light coming through the
       gap and bouncing off the slat below onto its lower edge. */
    const crown = 0.2;
    const lean = Math.sign(phi) || 1;
    const specPos = 0.5 - 0.42 * Math.sin(phi);
    const specStrength = metallic ? 0.5 : 0.16;
    const facing = Math.abs(Math.sin(phi));
    /* The gap sits below the slat, so the edge turned towards it is the lower
       one, and that is the edge the sky wraps around. Leaning the other way
       moves the bright edge to the top. Splitting it this way is what stops
       every slat reading as a symmetrical painted bar. */
    const bright = lean > 0 ? 1 : 0;

    const luminanceAt = (v) => {
      const u = (v - 0.5) * 2;
      const local = Math.abs(Math.sin(phi + crown * u * lean));
      /* Room ambient. The exterior sun is behind the blind and never reaches
         the room face directly, so this is the whole of the base term. */
      let k = 0.4 + 0.42 * local;
      /* Sky through the gap, bouncing off the slat below onto this one. */
      k += 0.4 * openness * smooth(0.34, 1, bright ? v : 1 - v);
      /* The crown is convex to the room, so its middle turns furthest towards
         the light in the room and reads a touch brighter than either edge. */
      k += 0.1 * Math.cos((v - 0.5) * Math.PI);
      k -= 0.1 * smooth(0.55, 0, bright ? v : 1 - v) * (1 - openness * 0.5);
      return k;
    };
    /* The edge is two tenths of a millimetre thick and sits against a blown
       out sky, so it scatters a fringe. It is the single detail that stops the
       blind reading as flat bands of colour.
       It has to fall away as the slat gets lighter. The fringe is the contrast
       between the scatter and the body of the slat, and a white slat is
       already as bright as the sky behind it, so there is nothing to see. Left
       flat, it blew White, Cream and Metallic Silver out until all three read
       as the same pale wash and the blind looked see through when its slats
       were seventy per cent overlapped. */
    const faceLum = (0.2126 * face.r + 0.7152 * face.g + 0.0722 * face.b) / 255;
    const contrast = 1 - faceLum * 0.82;
    const fringeAt = (v) => {
      const lit = bright ? smooth(0.7, 1, v) : smooth(0.3, 0, v);
      return lit * (0.16 + 0.52 * openness) * (0.3 + 0.7 * facing) * contrast;
    };
    const highlightAt = (v) => {
      const spec = Math.exp(-((v - specPos) ** 2) / 0.02) * specStrength * contrast;
      return (spec + fringeAt(v) * 0.5) * 205;
    };

    const grad = g.createLinearGradient(0, 0, 0, bandH);
    const steps = 13;
    for (let i = 0; i < steps; i += 1) {
      const v = i / (steps - 1);
      /* The fringe thins the slat rather than painting over it. Scattering
         round an edge that thin is partial occlusion, so letting the scene
         through is both what happens and what makes it look photographed: the
         highlight comes out sky coloured at the head of the pane and green
         down where the lawn is, instead of the same white rule fifty times. */
      grad.addColorStop(v, paint(face, luminanceAt(v), highlightAt(v), 1 - fringeAt(v) * 0.62));
    }
    g.fillStyle = grad;
    g.fillRect(0, 0, W, bandH);

    /* Metallic Silver and Rose Gold are flake finishes: the real slats sparkle
       plainly in the owner's photograph of the sample card, and painted flat
       they read as plastic. Deterministic from the index rather than
       `Math.random`, or the flecks would jump on every rebuild and the blind
       would crawl while a slider moved. */
    if (glitter && bandH > 1.5) {
      const flecks = Math.round(W * bandH * 0.05);
      for (let i = 0; i < flecks; i += 1) {
        const nx = Math.sin(i * 12.9898 + 4.1) * 43758.5453;
        const ny = Math.sin(i * 78.233 + 2.7) * 12345.6789;
        const nb = Math.sin(i * 39.4271 + 5.3) * 24634.6345;
        const x = (nx - Math.floor(nx)) * W;
        const y = (ny - Math.floor(ny)) * bandH;
        const bright = nb - Math.floor(nb);
        g.fillStyle = bright > 0.34
          ? `rgba(255,255,255,${(0.18 + bright * 0.5).toFixed(3)})`
          : `rgba(24,20,14,${(0.1 + bright * 0.4).toFixed(3)})`;
        g.fillRect(x, y, 1, Math.max(0.7, ss * 0.34));
      }
    }

    return { canvas: c, ss };
  };

  /* Everything that is not the blind. `glass` is the tint, the sheen and the
     vignette at glass size; `frame` is the aluminium, its mitres and the
     rebate shadow it throws, at canvas size and transparent everywhere else.
     An aluminium frame needs three bands rather than one flat fill, because
     what identifies a real one at a glance is the step down from the outer
     face to the glazing bead and the shadow that step drops onto the glass.
     Mitres go in at forty five degrees for the same reason: butt joints read
     as a box drawn round a picture. */
  const buildChrome = (L) => {
    const glass = document.createElement('canvas');
    glass.width = Math.max(1, Math.round(L.glassW));
    glass.height = Math.max(1, Math.round(L.glassH));
    const gg = glass.getContext('2d');
    if (gg) {
      const w = glass.width;
      const h = glass.height;
      gg.fillStyle = 'rgba(196,212,222,0.07)';
      gg.fillRect(0, 0, w, h);
      const sheen = gg.createLinearGradient(0, 0, w * 1.15, h * 0.8);
      sheen.addColorStop(0, 'rgba(255,255,255,0.16)');
      sheen.addColorStop(0.34, 'rgba(255,255,255,0.05)');
      sheen.addColorStop(0.52, 'rgba(255,255,255,0)');
      sheen.addColorStop(1, 'rgba(255,255,255,0.05)');
      gg.fillStyle = sheen;
      gg.fillRect(0, 0, w, h);
      const vignette = gg.createRadialGradient(w / 2, h / 2, Math.min(w, h) * 0.32, w / 2, h / 2, Math.max(w, h) * 0.72);
      vignette.addColorStop(0, 'rgba(0,0,0,0)');
      vignette.addColorStop(1, 'rgba(8,11,14,0.13)');
      gg.fillStyle = vignette;
      gg.fillRect(0, 0, w, h);
    }

    const frameCanvas = document.createElement('canvas');
    frameCanvas.width = Math.max(1, Math.round(width));
    frameCanvas.height = Math.max(1, Math.round(height));
    const f = frameCanvas.getContext('2d');
    if (!f) return { glass, frame: null };

    /* Anthracite uPVC, built from the owner's photograph of the showroom unit
       rather than as a bezel. What identifies it is the stepped section: an
       outer frame face, a shadow groove, the sash face, a second groove, then a
       bead curving down to the glass, with every band mitred at forty five
       degrees through the corners and carrying a soft highlight along its top
       edge. A flat rectangle in the same colour reads as a picture frame. */
    const bands = [
      { depth: OUTER, top: 0.78, face: 1.24, bottom: 0.92, dome: true },
      { depth: GROOVE, top: 0.24, face: 0.3, bottom: 0.4 },
      { depth: SASH, top: 0.86, face: 1.1, bottom: 0.78, dome: true },
      { depth: GROOVE, top: 0.22, face: 0.28, bottom: 0.38 },
      { depth: BEAD, top: 1.04, face: 0.82, bottom: 0.46, dome: true },
    ];

    const tone = (k) => paint(UPVC, k);
    let inset = 0;

    bands.forEach((band) => {
      const d = band.depth * L.scale;
      const x0 = L.x + inset;
      const y0 = L.y + inset;
      const w0 = L.unitW - inset * 2;
      const h0 = L.unitH - inset * 2;

      /* Each band is a ring. Painting it as four trapezia mitred at the
         corners is what puts the diagonal joint lines in, which is the single
         clearest sign that this is an extruded frame and not a border. */
      const ring = (side) => {
        f.beginPath();
        if (side === 'top') {
          f.moveTo(x0, y0); f.lineTo(x0 + w0, y0); f.lineTo(x0 + w0 - d, y0 + d); f.lineTo(x0 + d, y0 + d);
        } else if (side === 'bottom') {
          f.moveTo(x0, y0 + h0); f.lineTo(x0 + w0, y0 + h0); f.lineTo(x0 + w0 - d, y0 + h0 - d); f.lineTo(x0 + d, y0 + h0 - d);
        } else if (side === 'left') {
          f.moveTo(x0, y0); f.lineTo(x0, y0 + h0); f.lineTo(x0 + d, y0 + h0 - d); f.lineTo(x0 + d, y0 + d);
        } else {
          f.moveTo(x0 + w0, y0); f.lineTo(x0 + w0, y0 + h0); f.lineTo(x0 + w0 - d, y0 + h0 - d); f.lineTo(x0 + w0 - d, y0 + d);
        }
        f.closePath();
      };

      const shade = (side, from, to, vertical) => {
        const grad = vertical
          ? f.createLinearGradient(0, side === 'bottom' ? y0 + h0 : y0, 0, side === 'bottom' ? y0 + h0 - d : y0 + d)
          : f.createLinearGradient(side === 'right' ? x0 + w0 : x0, 0, side === 'right' ? x0 + w0 - d : x0 + d, 0);
        grad.addColorStop(0, tone(from));
        if (band.dome) grad.addColorStop(0.42, tone((from + to) / 2 + 0.12));
        grad.addColorStop(1, tone(to));
        f.fillStyle = grad;
        ring(side);
        f.fill();
      };

      shade('top', band.top, band.face, true);
      shade('bottom', band.bottom, band.face, true);
      shade('left', band.top * 0.94, band.face, false);
      shade('right', band.bottom * 0.94, band.face, false);
      inset += d;
    });

    /* The mitre joints themselves, and a hairline where the bead meets the
       glass so the sealed unit reads as sitting in a rebate. */
    f.strokeStyle = 'rgba(12,15,18,0.42)';
    f.lineWidth = Math.max(0.6, L.scale * 0.6);
    f.beginPath();
    [[L.x, L.y, L.glassX, L.glassY], [L.x + L.unitW, L.y, L.glassX + L.glassW, L.glassY],
      [L.x, L.y + L.unitH, L.glassX, L.glassY + L.glassH], [L.x + L.unitW, L.y + L.unitH, L.glassX + L.glassW, L.glassY + L.glassH]]
      .forEach(([ax, ay, bx, by]) => { f.moveTo(ax, ay); f.lineTo(bx, by); });
    f.stroke();

    /* Woodgrain foil. It runs along the length of each profile, so the head
       and cill are grained horizontally and the two jambs vertically. Running
       both ways over the whole frame produced a crosshatch that read as woven
       fabric rather than as uPVC. */
    const framePx = FRAME * L.scale;
    const grainPass = (clipX, clipY, clipW, clipH, vertical, count) => {
      f.save();
      f.beginPath();
      f.rect(clipX, clipY, clipW, clipH);
      f.clip();
      f.globalAlpha = 0.055;
      f.strokeStyle = '#ffffff';
      f.lineWidth = Math.max(0.4, L.scale * 0.35);
      f.beginPath();
      for (let i = 0; i < count; i += 1) {
        const n = Math.sin(i * 37.31 + (vertical ? 2.3 : 0)) * 8172.19;
        const t = n - Math.floor(n);
        if (vertical) {
          const x = L.x + t * L.unitW;
          f.moveTo(x, clipY);
          f.lineTo(x, clipY + clipH);
        } else {
          const y = L.y + t * L.unitH;
          f.moveTo(clipX, y);
          f.lineTo(clipX + clipW, y);
        }
      }
      f.stroke();
      f.restore();
    };
    grainPass(L.x, L.y, L.unitW, framePx, false, 150);
    grainPass(L.x, L.y + L.unitH - framePx, L.unitW, framePx, false, 150);
    grainPass(L.x, L.y, framePx, L.unitH, true, 120);
    grainPass(L.x + L.unitW - framePx, L.y, framePx, L.unitH, true, 120);

    f.strokeStyle = 'rgba(6,9,12,0.62)';
    f.lineWidth = Math.max(1, L.scale * 1.1);
    f.strokeRect(L.glassX, L.glassY, L.glassW, L.glassH);
    f.strokeStyle = 'rgba(255,255,255,0.24)';
    f.lineWidth = 1;
    f.strokeRect(L.x + 0.5, L.y + 0.5, L.unitW - 1, L.unitH - 1);

    return { glass, frame: frameCanvas };
  };

  /* Where the two magnets sit and how far each one travels. Both run on one
     slim vertical rail near the right of the glass, the upper one tilting and
     the lower one lifting, which is how the unit is actually operated. Kept as
     one function so the renderer and the pointer handling cannot drift apart:
     a magnet drawn somewhere it cannot be grabbed is the obvious way for this
     to break. */
  const magnetTracks = (L) => {
    const cassettePx = CASSETTE * L.scale;
    const spacerPx = SPACER * L.scale;
    const top = L.glassY + cassettePx;
    const bottom = L.glassY + L.glassH - spacerPx;
    const span = bottom - top;
    /* On the rail at the inner edge of the right hand member, where the frame
       meets the clear. The magnets slot onto that rail; they do not sit in the
       middle of the frame, which is where an earlier pass put them. */
    const railX = L.glassX + L.glassW - cassettePx;
    const railW = RAIL_W * L.scale;
    /* The rail is a guide, not a seat. The magnet sits alongside it with its
       near edge against the rail's far edge, on the frame side, which is what
       both reference photographs show and how it is described. Centring it on
       the rail put it half over the clear. */
    const x = railX + railW / 2 + (MAGNET_W * L.scale) / 2;
    const w = MAGNET_W * L.scale;
    const hTilt = MAGNET_H_TILT * L.scale;
    const hLift = MAGNET_H_LIFT * L.scale;
    return {
      x,
      w,
      memberW: cassettePx,
      railX,
      railW,
      railTop: L.glassY,
      railBottom: bottom,
      hTilt,
      hLift,
      tilt: { top: top + hTilt * 0.6, bottom: top + span * 0.2 },
      /* Inverted on the owner's instruction, and it is how the geared magnet
         actually runs: the magnet at the top of its travel is the blind down
         and closed, and pulling it down is what raises the blind open. */
      lift: { top: top + span * 0.36, bottom: bottom - hLift * 0.6 },
    };
  };

  const magnetCentre = (L, which) => {
    const t = magnetTracks(L);
    const track = t[which];
    const amount = which === 'tilt' ? tilt / 100 : lift / 100;
    return {
      x: t.x,
      y: track.top + (track.bottom - track.top) * clamp(amount, 0, 1),
      w: t.w,
      h: which === 'tilt' ? t.hTilt : t.hLift,
    };
  };

  const roundedRect = (c, x, y, w, h, r) => {
    const radius = Math.min(r, w / 2, h / 2);
    c.beginPath();
    c.moveTo(x + radius, y);
    c.arcTo(x + w, y, x + w, y + h, radius);
    c.arcTo(x + w, y + h, x, y + h, radius);
    c.arcTo(x, y + h, x, y, radius);
    c.arcTo(x, y, x + w, y, radius);
    c.closePath();
  };

  /* Everything sealed inside the glass in front of the blind: the spacer round
     the edge of the unit, the blind's head, the rail and the two magnets. All
     of it is matched to the window frame rather than to the slats, which is
     what the owner's unit shows: anthracite hardware against silver slats. */
  const drawInternals = (L, blindX, blindY, blindW, blindH) => {
    const cassettePx = CASSETTE * L.scale;
    const spacerPx = SPACER * L.scale;
    const t = magnetTracks(L);

    /* The cassette is colour matched to the slats, on the owner's instruction
       of 2026-08-04. It is satin rather than the same value: an extrusion next
       to a rolled slat in the same colour still reads as a different material,
       and without the shift the frame and a closed blind merge into one slab. */
    const shell = mixRgb(shownFace, { r: 108, g: 112, b: 114 }, 0.16);
    /* How far shading is allowed to travel from the base colour. On a dark
       frame a groove has to go a long way down to read at all; on a white one
       the same ratio turns it grey, which is what made the rail and the
       magnets look dirty on the white finishes. Light colours therefore get a
       shallower floor and dark colours a deeper one. */
    const shellLum = (0.2126 * shell.r + 0.7152 * shell.g + 0.0722 * shell.b) / 255;
    const floor = (k) => k + (1 - k) * shellLum * 0.82;

    /* Warm edge spacer, visible only along the foot. Everywhere else the
       cassette stands in front of it. */
    const foot = ctx.createLinearGradient(0, L.glassY + L.glassH - spacerPx, 0, L.glassY + L.glassH);
    foot.addColorStop(0, 'rgba(14,17,20,0.98)');
    foot.addColorStop(0.55, 'rgba(24,28,32,0.96)');
    foot.addColorStop(1, 'rgba(10,13,16,0.99)');
    ctx.fillStyle = foot;
    ctx.fillRect(L.glassX, L.glassY + L.glassH - spacerPx, L.glassW, spacerPx);

    /* Two side members and a head, about fifty millimetres each, and nothing
       across the bottom: the bottom rail comes to rest on the edge of the
       glass. Flat faced with the light along one edge; a bright band down the
       middle makes each member read as a tube. */
    const member = (x, y, w, h, vertical, flip) => {
      const grad = vertical
        ? ctx.createLinearGradient(x, y, x + w, y)
        : ctx.createLinearGradient(x, y, x, y + h);
      grad.addColorStop(0, paint(shell, flip ? floor(0.6) : 1.04, flip ? 0 : 14));
      grad.addColorStop(0.18, paint(shell, flip ? floor(0.68) : 0.94, flip ? 0 : 6));
      grad.addColorStop(0.82, paint(shell, flip ? 0.94 : floor(0.68), flip ? 6 : 0));
      grad.addColorStop(1, paint(shell, flip ? 1.04 : floor(0.58), flip ? 14 : 0));
      ctx.fillStyle = grad;
      ctx.fillRect(x, y, w, h);
    };
    member(L.glassX, L.glassY, cassettePx, L.glassH - spacerPx, true, false);
    member(L.glassX + L.glassW - cassettePx, L.glassY, cassettePx, L.glassH - spacerPx, true, true);
    member(L.glassX, L.glassY, L.glassW, cassettePx, false, false);

    /* Shadow off the inner edge of each member onto the blind behind it. */
    const line = Math.max(0.7, L.scale * 0.7);
    ctx.fillStyle = 'rgba(8,11,14,0.38)';
    ctx.fillRect(blindX, blindY, blindW, line);
    ctx.fillRect(blindX, blindY, line, blindH);
    ctx.fillRect(blindX + blindW - line, blindY, line, blindH);

    /* The rail, at the inner edge of the right hand member where the frame
       meets the clear. This is what the magnets slot onto. */
    const rail = ctx.createLinearGradient(t.railX - t.railW / 2, 0, t.railX + t.railW / 2, 0);
    /* A groove, read by the highlight along its clear-side edge rather than by
       its own tone: it is the same colour as the member it is cut into. */
    rail.addColorStop(0, paint(shell, 1.12, 22));
    rail.addColorStop(0.16, paint(shell, floor(0.44)));
    rail.addColorStop(0.55, paint(shell, floor(0.34)));
    rail.addColorStop(0.86, paint(shell, floor(0.52)));
    rail.addColorStop(1, paint(shell, 0.94, 12));
    ctx.fillStyle = rail;
    ctx.fillRect(t.railX - t.railW / 2, L.glassY + cassettePx * 0.72, t.railW, L.glassH - spacerPx - cassettePx * 0.72);

    /* The magnet caps are the cassette colour taken a shade deeper and read
       glossy against it, so they stand out on a white blind as clearly as on a
       black one. */
    const cap = mixRgb(shell, { r: 26, g: 29, b: 32 }, 0.16);

    ['tilt', 'lift'].forEach((which) => {
      const m = magnetCentre(L, which);
      const x = m.x - m.w / 2;
      const y = m.y - m.h / 2;
      /* Generously rounded, glossy, and about one to two point two. The
         owner's photograph is the reference: an earlier pass had them as slim
         capsules at one to three and a half, which read as pins. */
      const radius = m.w * 0.17;

      ctx.save();
      ctx.shadowColor = 'rgba(6,9,12,0.62)';
      ctx.shadowBlur = Math.max(2.5, m.w * 0.42);
      ctx.shadowOffsetX = Math.max(1, m.w * 0.1);
      ctx.shadowOffsetY = Math.max(1.5, m.w * 0.16);
      roundedRect(ctx, x, y, m.w, m.h, radius);
      /* A flat faced block, not a tube. Reading dark, light, dark straight
         across the width made it look cylindrical; the real one is a broad
         even face with one crisp turned edge near the right and thin dark
         returns at both sides. */
      /* Matte, not glossy. An earlier pass gave it a hard specular sheet,
         which is a plastic look the real moulding does not have: the
         references show a soft, almost even face with the light falling away
         gently to a darker edge on each side. */
      const body = ctx.createLinearGradient(x, y, x + m.w, y);
      body.addColorStop(0, paint(cap, floor(0.42)));
      body.addColorStop(0.12, paint(cap, floor(0.78), 4));
      body.addColorStop(0.34, paint(cap, floor(0.98), 12));
      body.addColorStop(0.58, paint(cap, floor(0.92), 8));
      body.addColorStop(0.84, paint(cap, floor(0.7), 2));
      body.addColorStop(1, paint(cap, floor(0.4)));
      ctx.fillStyle = body;
      ctx.fill();
      ctx.restore();

      /* The top face catches a hard glint and the bottom rolls into shadow,
         which is what makes it read as moulded and proud of the glass. */
      /* Just enough to round the ends. A hard glint across the top read as
         polished; the moulding is satin. */
      const roll = ctx.createLinearGradient(0, y, 0, y + m.h);
      roll.addColorStop(0, 'rgba(255,255,255,0.2)');
      roll.addColorStop(0.045, 'rgba(255,255,255,0.06)');
      roll.addColorStop(0.12, 'rgba(0,0,0,0.05)');
      roll.addColorStop(0.5, 'rgba(0,0,0,0)');
      roll.addColorStop(0.9, 'rgba(0,0,0,0.12)');
      roll.addColorStop(1, 'rgba(0,0,0,0.34)');
      roundedRect(ctx, x, y, m.w, m.h, radius);
      ctx.fillStyle = roll;
      ctx.fill();

      ctx.strokeStyle = 'rgba(4,6,8,0.72)';
      ctx.lineWidth = Math.max(0.7, L.scale * 0.6);
      roundedRect(ctx, x, y, m.w, m.h, radius);
      ctx.stroke();

      if (focused === which) {
        ctx.strokeStyle = '#2eac66';
        ctx.lineWidth = Math.max(1.8, m.w * 0.14);
        roundedRect(ctx, x - m.w * 0.3, y - m.w * 0.3, m.w * 1.6, m.h + m.w * 0.6, radius * 1.6);
        ctx.stroke();
      }
    });
  };

  const layout = () => {
    const box = stage.getBoundingClientRect();
    const w = Math.max(160, Math.round(box.width));
    const h = Math.max(160, Math.round(box.height));
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    width = w;
    height = h;

    const scale = Math.min(w / UNIT_W, h / UNIT_H);
    const unitW = UNIT_W * scale;
    const unitH = UNIT_H * scale;
    return {
      scale,
      x: (w - unitW) / 2,
      y: (h - unitH) / 2,
      unitW,
      unitH,
      glassX: (w - unitW) / 2 + FRAME * scale,
      glassY: (h - unitH) / 2 + FRAME * scale,
      glassW: GLASS_W * scale,
      glassH: GLASS_H * scale,
    };
  };

  const draw = (settled = true) => {
    const L = layout();

    /* Resize only when the backing store is genuinely a different size. The
       assignment is what clears the canvas, so doing it unconditionally throws
       away a frame's work every time. */
    const storeW = Math.round(width * dpr);
    const storeH = Math.round(height * dpr);
    if (canvas.width !== storeW || canvas.height !== storeH) {
      canvas.width = storeW;
      canvas.height = storeH;
      sceneKey = '';
      tileKey = '';
      chromeKey = '';
    }
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

    const phi = ((tilt / 100) - 0.5) * 2 * MAX_TILT;
    const pitchPx = PITCH * L.scale;
    const slatPx = (SLAT * Math.abs(Math.sin(phi)) + SLAT_T * Math.abs(Math.cos(phi))) * L.scale;

    ctx.fillStyle = '#151719';
    ctx.fillRect(0, 0, width, height);

    const key = `${Math.round(L.glassW)}x${Math.round(L.glassH)}`;
    if (sceneKey !== key) {
      scene = buildScene(L.glassW, L.glassH);
      sceneKey = key;
    }

    ctx.save();
    ctx.beginPath();
    ctx.rect(L.glassX, L.glassY, L.glassW, L.glassH);
    ctx.clip();

    if (scene && scene.view) ctx.drawImage(scene.view, L.glassX, L.glassY, L.glassW, L.glassH);

    const cassettePx = CASSETTE * L.scale;
    const spacerPx = SPACER * L.scale;
    const blindX = L.glassX + cassettePx;
    const blindY = L.glassY + cassettePx;
    const blindW = L.glassW - cassettePx * 2;
    const blindH = L.glassH - cassettePx - spacerPx;
    const headPx = HEADRAIL * L.scale;
    const railPx = RAIL * L.scale;
    const raised = clamp(lift / 100, 0, 1);
    const stacked = Math.round(SLAT_COUNT * raised);
    const deployed = SLAT_COUNT - stacked;
    const stackPx = stacked * STACK_PITCH * L.scale;
    /* The blind hangs from the head and gathers onto its own bottom rail as it
       rises, so the stack sits at the foot of the drop with the hanging slats
       above it, and the whole group travels up together. It was drawn at the
       head with the hanging slats below, which is the wrong way round and is
       not how the owner's blinds behave. */
    const topPx = blindY + headPx;
    const stackTop = topPx + deployed * pitchPx;

    const tKey = `${shownFace.r | 0},${shownFace.g | 0},${shownFace.b | 0},${shownBack.r | 0},${shownBack.g | 0},${shownBack.b | 0},${shownMetallic.toFixed(2)},${shownGlitter.toFixed(2)},${phi.toFixed(4)},${pitchPx.toFixed(2)},${slatPx.toFixed(2)}`;
    if (tileKey !== tKey) {
      /* Which side of the slat the room is looking at. A venetian presents
         opposite faces in its two closed positions, so on a two sided slat
         tilting one way shows white and the other shows anthracite. The swap
         happens at edge on, where the slat is invisible, so it is never seen
         to happen. On the seven single sided colours `back` is `face` and this
         does nothing. The cassette, the head, the bottom rail and the stack all
         stay on `shownFace`: they do not rotate, so the room always sees the
         room side of them, which is why the frame on White/Anthracite stays
         white however the slats are turned. */
      const roomSide = phi >= 0 ? shownFace : shownBack;
      const outSide = phi >= 0 ? shownBack : shownFace;
      tile = buildTile(roomSide, outSide, shownMetallic > 0.5, shownGlitter > 0.5, phi, pitchPx, slatPx);
      tileKey = tKey;
    }

    if (tile && deployed > 0) {
      /* The wobble index is the slat, not the row, and the slats still hanging
         are the top ones: slat 0 is under the head and stays there until the
         rising stack reaches it. Indexing from `SLAT_COUNT - deployed` instead
         shifted every slat's offset, gain and lean along by one each time one
         was taken up, so the whole blind appeared to creep and roll as it was
         raised when each slat should sit dead still until it is bunched. That
         offset was correct only while the stack was drawn under the head, and
         was left behind when the stack moved to the foot. */
      const midX = blindX + blindW / 2;
      for (let i = 0; i < deployed; i += 1) {
        const w = wobble[i] || { offset: 0, gain: 0, lean: 0 };
        const y = topPx + i * pitchPx + w.offset * pitchPx * 0.04;
        ctx.globalAlpha = 1 + w.gain * 0.04;
        /* About a twentieth of a degree of lean per slat, a quarter of what
           it was. Perfectly level slats still read as a printed rule, so some
           variation has to stay, but at the old strength the blind looked
           damaged rather than hung: the owner asked for roughly seventy five
           per cent more consistency and this is that. Position and brightness
           came down by the same quarter, together, or reducing one alone just
           shifts which cue reads as the defect. */
        ctx.save();
        ctx.translate(midX, y + pitchPx / 2);
        ctx.rotate(w.lean * 0.00105);
        ctx.drawImage(tile.canvas, -blindW / 2 - 2, -pitchPx / 2, blindW + 4, pitchPx);
        ctx.restore();
      }
      ctx.globalAlpha = 1;
    }

    /* The stack, gathered on top of the bottom rail. Slats are conserved, so
       raising the blind moves them out of the drop and into this band rather
       than shrinking the drop and losing them. */
    if (stacked > 0) {
      const y = stackTop;
      ctx.fillStyle = paint(shownFace, 0.52);
      ctx.fillRect(blindX, y, blindW, stackPx);
      const linePx = STACK_PITCH * L.scale;
      if (linePx >= 1.4) {
        ctx.fillStyle = paint(shownFace, 0.92, 18, 0.55);
        for (let i = 0; i < stacked; i += 1) {
          ctx.fillRect(blindX, y + i * linePx, blindW, Math.max(0.6, linePx * 0.34));
        }
      } else {
        const texture = ctx.createLinearGradient(0, y, 0, y + stackPx);
        texture.addColorStop(0, paint(shownFace, 1.05, 20, 0.4));
        texture.addColorStop(1, paint(shownFace, 0.62, 0, 0.4));
        ctx.fillStyle = texture;
        ctx.fillRect(blindX, y, blindW, stackPx);
      }
      ctx.fillStyle = 'rgba(255,255,255,0.16)';
      ctx.fillRect(blindX, y, blindW, Math.max(0.7, L.scale * 1.2));
      const drop = ctx.createLinearGradient(0, y + stackPx, 0, y + stackPx + railPx * 1.8);
      drop.addColorStop(0, 'rgba(10,13,16,0.45)');
      drop.addColorStop(1, 'rgba(10,13,16,0)');
      ctx.fillStyle = drop;
      ctx.fillRect(blindX, y + stackPx, blindW, railPx * 1.8);
    }

    /* The bottom rail, under whatever has gathered on it. Outside the slat
       branch on purpose: it is still there when the blind is fully raised and
       every slat is in the stack. */
    const railY = stackTop + stackPx;
    const rail = ctx.createLinearGradient(0, railY, 0, railY + railPx);
    rail.addColorStop(0, paint(shownFace, 0.86, 26));
    rail.addColorStop(0.45, paint(shownFace, 0.6));
    rail.addColorStop(1, paint(shownFace, 0.4));
    ctx.fillStyle = rail;
    ctx.fillRect(blindX, railY, blindW, railPx);
    const under = ctx.createLinearGradient(0, railY + railPx, 0, railY + railPx * 2.4);
    under.addColorStop(0, 'rgba(10,13,16,0.4)');
    under.addColorStop(1, 'rgba(10,13,16,0)');
    ctx.fillStyle = under;
    ctx.fillRect(blindX, railY + railPx, blindW, railPx * 1.4);

    /* Veiling glare. The blurred garden added back over the finished blind, so
       the light coming through the gaps spills onto the slats beside them. */
    if (scene && scene.haze) {
      ctx.save();
      ctx.globalCompositeOperation = 'lighter';
      /* Glare scales against the slat, not the window. Adding the same wash to
         a white blind as to a black one turned White, Cream and Metallic
         Silver green, because the garden was being added to a surface that had
         no headroom left to take it. */
      const faceLum = (0.2126 * shownFace.r + 0.7152 * shownFace.g + 0.0722 * shownFace.b) / 255;
      ctx.globalAlpha = 0.11 * (0.34 + 0.66 * (1 - faceLum * 0.86));
      ctx.drawImage(scene.haze, L.glassX, L.glassY, L.glassW, L.glassH);
      ctx.restore();
    }

    /* Ladder cords. Fine, taut and only really visible where they cross a dark
       slat, which is why they go on with `lighter` rather than as flat paint:
       against the gaps they all but disappear, exactly as in the photography.
       They belong to the blind, so they run only from the foot of the stack to
       the bottom rail and come up with it. Drawn full height they stayed behind
       as a pair of wires hanging over clear glass once the blind was raised. */
    const cordTop = topPx;
    const cordBottom = stackTop + stackPx + railPx;
    if (cordBottom - cordTop > 1) {
      const cordW = Math.max(0.6, L.scale * 0.9);
      ctx.save();
      ctx.globalCompositeOperation = 'lighter';
      ctx.fillStyle = 'rgba(126,132,128,0.34)';
      [0.24, 0.76].forEach((at) => {
        ctx.fillRect(blindX + blindW * at, cordTop, cordW, cordBottom - cordTop);
      });
      ctx.restore();
    }

    /* The Notan profile, colour matched to the slats, and the two magnets that
       run on it. This is the product: the controls are on the frame sealed
       inside the glass, not beside the picture of it. */
    drawInternals(L, blindX, blindY, blindW, blindH);
    placeGrabs(L);

    ctx.restore();

    /* Glass and frame are both cached: neither depends on tilt, lift or
       colour, so recomputing a dozen gradients for them on every frame of a
       slider drag was the largest single cost in the loop and bought nothing.
       They rebuild only when the box resizes. */
    if (chromeKey !== key) {
      unitChrome = buildChrome(L);
      chromeKey = key;
    }
    if (unitChrome) {
      if (unitChrome.glass) ctx.drawImage(unitChrome.glass, L.glassX, L.glassY, L.glassW, L.glassH);
      if (unitChrome.frame) ctx.drawImage(unitChrome.frame, 0, 0, width, height);
    }

    /* Grain is a static texture over a still image, so it can wait for the
       last frame of a movement. Skipping it while the sliders are moving takes
       a full canvas `overlay` composite out of the animating path, which is
       what keeps a mid-range phone smooth during a drag. */
    if (settled) {
      if (!grain) grain = buildGrain();
      const pattern = grain ? ctx.createPattern(grain, 'repeat') : null;
      if (pattern) {
        ctx.save();
        ctx.globalAlpha = 0.05;
        ctx.globalCompositeOperation = 'overlay';
        ctx.fillStyle = pattern;
        ctx.fillRect(0, 0, width, height);
        ctx.restore();
      }
    }
  };

  /* Names the colour and nothing else. It used to narrate the tilt and lift
     positions as well, which the owner did not want: the magnets show where
     they are, and the two range inputs announce their own values to a screen
     reader, so the commentary was duplicating both. */
  const describe = () => {
    if (!readout) return;
    const swatch = swatches[activeIndex];
    readout.textContent = `${swatch.name}${swatch.code ? ` ${swatch.code}` : ''}`;
  };

  const step = () => {
    frame = 0;
    const ease = still ? 1 : 0.19;
    const target = swatches[activeIndex];
    const dt = tiltTarget - tilt;
    const dl = liftTarget - lift;
    const df = target.metallic ? 1 : 0;
    const dg = target.glitter ? 1 : 0;

    tilt += dt * ease;
    lift += dl * ease;
    shownFace = mixRgb(shownFace, target.face, ease);
    shownBack = mixRgb(shownBack, target.back, ease);
    shownMetallic += (df - shownMetallic) * ease;
    shownGlitter += (dg - shownGlitter) * ease;

    let settled = Math.abs(dt) < 0.02 && Math.abs(dl) < 0.02;
    settled = settled && Math.abs(shownFace.r - target.face.r) < 0.4 && Math.abs(shownFace.g - target.face.g) < 0.4 && Math.abs(shownFace.b - target.face.b) < 0.4;
    settled = settled && Math.abs(shownBack.r - target.back.r) < 0.4 && Math.abs(shownMetallic - df) < 0.01 && Math.abs(shownGlitter - dg) < 0.01;

    if (settled) {
      tilt = tiltTarget;
      lift = liftTarget;
      shownFace = { ...target.face };
      shownBack = { ...target.back };
      shownMetallic = df;
      shownGlitter = dg;
    }

    draw(settled);

    if (!settled && visible) frame = window.requestAnimationFrame(step);
  };

  const nudge = () => {
    if (frame) return;
    frame = window.requestAnimationFrame(step);
  };

  tiltInput.addEventListener('input', () => {
    tiltTarget = clamp(Number.parseFloat(tiltInput.value) || 0, 0, 100);
    describe();
    nudge();
  });
  liftInput.addEventListener('input', () => {
    liftTarget = clamp(Number.parseFloat(liftInput.value) || 0, 0, 100);
    describe();
    nudge();
  });

  [['tilt', tiltInput], ['lift', liftInput]].forEach(([which, input]) => {
    input.addEventListener('focus', () => { focused = which; nudge(); });
    input.addEventListener('blur', () => { focused = focused === which ? null : focused; nudge(); });
  });

  /* Dragging the magnets. The two grab elements are positioned over the drawn
     magnets and are the only things on the stage with `touch-action: none`, so
     a drag that starts on a magnet is a drag and a drag anywhere else on the
     glass still scrolls the page. Hit testing the canvas instead could not do
     that: by the time a pointerdown handler runs, a touch has already been
     committed to a scroll. */
  const applyDrag = (which, clientY) => {
    const L = layout();
    const track = magnetTracks(L)[which];
    const box = canvas.getBoundingClientRect();
    const y = clientY - box.top;
    const along = clamp((y - track.top) / Math.max(1, track.bottom - track.top));
    const value = Math.round(along * 200) / 2;

    if (which === 'tilt') {
      tiltTarget = value;
      tiltInput.value = String(value);
    } else {
      liftTarget = value;
      liftInput.value = String(value);
    }

    describe();
    nudge();
  };

  const placeGrabs = (L) => {
    grabs.forEach((grab, which) => {
      const m = magnetCentre(L, which);
      /* Padded out to a real touch target. The magnet itself is about sixteen
         pixels across at the size this renders. */
      const w = Math.max(46, m.w + 26);
      const h = Math.max(48, m.h + 16);
      grab.style.left = `${(m.x - w / 2).toFixed(1)}px`;
      grab.style.top = `${(m.y - h / 2).toFixed(1)}px`;
      grab.style.width = `${w.toFixed(1)}px`;
      grab.style.height = `${h.toFixed(1)}px`;
    });
  };

  grabs.forEach((grab, which) => {
    grab.addEventListener('pointerdown', (event) => {
      dragging = which;
      focused = which;
      grab.setPointerCapture?.(event.pointerId);
      grab.classList.add('is-held');
      event.preventDefault();
      applyDrag(which, event.clientY);
    });

    grab.addEventListener('pointermove', (event) => {
      if (dragging !== which) return;
      event.preventDefault();
      applyDrag(which, event.clientY);
    });

    const release = (event) => {
      if (dragging !== which) return;
      dragging = null;
      grab.classList.remove('is-held');
      grab.releasePointerCapture?.(event.pointerId);
    };

    grab.addEventListener('pointerup', release);
    grab.addEventListener('pointercancel', release);
  });


  colourButtons.forEach((button, index) => {
    button.addEventListener('click', () => {
      activeIndex = index;
      colourButtons.forEach((other, i) => {
        other.classList.toggle('is-active', i === index);
        other.setAttribute('aria-pressed', i === index ? 'true' : 'false');
      });
      describe();
      nudge();
    });
  });

  if ('ResizeObserver' in window) {
    let last = '';
    const observer = new ResizeObserver(() => {
      const box = stage.getBoundingClientRect();
      const key = `${Math.round(box.width)}x${Math.round(box.height)}`;
      if (key === last) return;
      last = key;
      sceneKey = '';
      tileKey = '';
      chromeKey = '';
      nudge();
    });
    observer.observe(stage);
  } else {
    window.addEventListener('resize', () => {
      sceneKey = '';
      tileKey = '';
      chromeKey = '';
      nudge();
    });
  }

  if ('IntersectionObserver' in window) {
    const seen = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        visible = entry.isIntersecting;
        if (visible) nudge();
      });
    }, { rootMargin: '160px' });
    seen.observe(stage);
  }

  root.classList.add('is-live');
  describe();
  draw();
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

  // Deep link: /colour-options/?material=upvc&colour=basalt-grey pre-selects
  // the matching swatch and scrolls to its material section.
  try {
    const params = new URLSearchParams(window.location.search);
    const wantColour = params.get('colour');
    if (wantColour) {
      const material = carousel.closest('[data-fg-colour-material]');
      const materialKey = material?.getAttribute('data-fg-colour-material') || '';
      const wantMaterial = params.get('material');
      if (!wantMaterial || wantMaterial === materialKey) {
        const idx = slides.findIndex((slide) => slide.getAttribute('data-colour-slug') === wantColour);
        if (idx >= 0) {
          activeIndex = idx;
          const target = material || carousel;
          const lenis = window.fensterLenis;
          let cancelled = false;
          const release = () => {
            cancelled = true;
            lenis?.start?.();
          };
          ['wheel', 'touchstart', 'keydown', 'pointerdown'].forEach((eventName) => {
            window.addEventListener(eventName, release, { once: true, passive: true });
          });
          const settle = () => {
            if (cancelled) return;
            const y = Math.max(0, target.getBoundingClientRect().top + window.scrollY - 96);
            if (lenis?.scrollTo) {
              lenis.scrollTo(y, { immediate: true, force: true });
            } else {
              window.scrollTo(0, y);
            }
          };
          // Wait for load so the colour hero images have sized the page, then
          // pause Lenis, jump to the swatch, re-assert briefly and hand smooth
          // scrolling back. Running before load leaves the jump pinned at top.
          const run = () => {
            if (cancelled) return;
            lenis?.stop?.();
            settle();
            [120, 350, 700].forEach((delay) => window.setTimeout(() => {
              if (!cancelled) settle();
            }, delay));
            window.setTimeout(() => {
              if (!cancelled) {
                settle();
                lenis?.start?.();
              }
            }, 950);
          };
          if (document.readyState === 'complete') {
            window.setTimeout(run, 60);
          } else {
            window.addEventListener('load', () => window.setTimeout(run, 60), { once: true });
          }
        }
      }
    }
  } catch (error) {
    /* deep link is best-effort */
  }

  update();
});

document.querySelectorAll('[data-fg-sash-carousel]').forEach((carousel) => {
  const track = carousel.querySelector('[data-fg-sash-track]');
  const slides = [...carousel.querySelectorAll('[data-fg-sash-slide]')];
  const panels = [...carousel.querySelectorAll('[data-fg-sash-spec-panel]')];
  const dots = [...carousel.querySelectorAll('[data-fg-sash-dot]')];
  const previous = carousel.querySelector('[data-fg-sash-prev]');
  const next = carousel.querySelector('[data-fg-sash-next]');
  const name = carousel.querySelector('[data-fg-sash-name]');
  const count = carousel.querySelector('[data-fg-sash-count]');
  const mobileQuery = window.matchMedia('(max-width: 860px)');
  let activeIndex = 0;
  let pointerId = null;
  let pointerStartX = 0;
  let dragDistance = 0;

  if (!track || slides.length < 2) return;

  const update = () => {
    track.style.setProperty('--fg-sash-index', String(activeIndex));
    track.style.setProperty('--fg-sash-drag', '0');

    slides.forEach((slide, index) => {
      if (mobileQuery.matches) {
        slide.setAttribute('aria-hidden', index === activeIndex ? 'false' : 'true');
      } else {
        slide.removeAttribute('aria-hidden');
      }
    });

    panels.forEach((panel, index) => {
      panel.hidden = index !== activeIndex;
    });

    dots.forEach((dot, index) => {
      dot.setAttribute('aria-pressed', index === activeIndex ? 'true' : 'false');
    });

    if (name) {
      name.textContent = slides[activeIndex]?.querySelector('h3')?.textContent?.trim() || '';
    }

    if (count) {
      count.textContent = `${String(activeIndex + 1).padStart(2, '0')} / ${String(slides.length).padStart(2, '0')}`;
    }
  };

  const goTo = (index) => {
    activeIndex = (index + slides.length) % slides.length;
    update();
  };

  const finishDrag = (event) => {
    if (pointerId === null || event.pointerId !== pointerId) return;
    const threshold = Math.min(72, carousel.clientWidth * 0.16);

    carousel.classList.remove('is-dragging');
    if (dragDistance <= -threshold) {
      activeIndex = (activeIndex + 1) % slides.length;
    } else if (dragDistance >= threshold) {
      activeIndex = (activeIndex - 1 + slides.length) % slides.length;
    }

    pointerId = null;
    dragDistance = 0;
    update();
  };

  previous?.addEventListener('click', () => goTo(activeIndex - 1));
  next?.addEventListener('click', () => goTo(activeIndex + 1));

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => goTo(index));
  });

  track.addEventListener('pointerdown', (event) => {
    if (!mobileQuery.matches) return;
    pointerId = event.pointerId;
    pointerStartX = event.clientX;
    dragDistance = 0;
    carousel.classList.add('is-dragging');
    track.setPointerCapture?.(event.pointerId);
  });

  track.addEventListener('pointermove', (event) => {
    if (pointerId === null || event.pointerId !== pointerId) return;
    dragDistance = Math.max(-carousel.clientWidth, Math.min(carousel.clientWidth, event.clientX - pointerStartX));
    track.style.setProperty('--fg-sash-drag', String(dragDistance));
  });

  track.addEventListener('pointerup', finishDrag);
  track.addEventListener('pointercancel', finishDrag);

  carousel.addEventListener('keydown', (event) => {
    if (!mobileQuery.matches || !['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
    event.preventDefault();
    goTo(activeIndex + (event.key === 'ArrowRight' ? 1 : -1));
  });

  carousel.setAttribute('tabindex', '0');
  mobileQuery.addEventListener?.('change', update);
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

  /* An optional play/pause button for this video, addressed by id.
     A looping hero film needs a pause control or it is audit finding [150], and
     the native `controls` bar is the wrong answer on a hero: it paints a black
     chrome strip over the poster from the moment the page loads, which is what
     the owner reported on 2026-08-18. This gives the same capability in the
     site's own language.

     It lives inside this loop deliberately, so it can reach `loadVideo` and
     start a film whose source has not been attached yet. A visitor on reduced
     motion or a metered connection gets the poster and this button, which is
     exactly the behaviour that finding asks for. */
  const toggle = video.id ? document.querySelector(`[data-fg-video-toggle="${video.id}"]`) : null;

  if (toggle) {
    const syncToggle = () => {
      const playing = !video.paused && !video.ended;
      toggle.setAttribute('aria-pressed', playing ? 'true' : 'false');
      toggle.setAttribute('aria-label', playing
        ? toggle.dataset.labelPause || 'Pause the film'
        : toggle.dataset.labelPlay || 'Play the film');
      toggle.classList.toggle('is-playing', playing);
    };

    toggle.hidden = false;
    toggle.addEventListener('click', () => {
      if (video.dataset.loaded !== 'true') {
        loadVideo();
        return;
      }
      if (video.paused) {
        video.play?.().catch(() => {});
      } else {
        video.pause();
      }
    });
    ['play', 'pause', 'ended', 'loadeddata'].forEach((e) => video.addEventListener(e, syncToggle));
    syncToggle();
  }

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

/* Scrub a video from its own position in the viewport. Deliberately not the
   [data-fg-product-video-final] traveller above: that one lifts the video out
   of the flow and flies it across the page from a slot beside the hero, which
   is the bifold treatment. This one never moves. It sits where it is rendered
   and only maps scroll progress onto currentTime.

   Verification note: this cannot be checked by watching it. Headless runs about
   one rAF per render and a hidden tab throttles them to nothing, so a real
   scroll reads as "did not move" in both. Assert on the seek instead, the way
   the colour rail release was proved. */
document.querySelectorAll('[data-fg-scrub-video]').forEach((video) => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  video.muted = true;
  video.playsInline = true;

  let duration = 0;
  let ticking = false;
  let primed = false;

  /* iOS Safari will not paint a frame from a currentTime seek on a video that
     has never played. The decoder is not primed, and preload="auto" is treated
     as metadata-only there, so the element sits on its first frame while every
     seek is accepted and quietly ignored. That is why this worked everywhere
     except iOS.

     Muted inline playback is allowed without a user gesture, so starting it
     once and immediately pausing primes the decoder and starts the buffering
     that seeking needs. Harmless on desktop, which is why it is not behind a
     UA check: a muted play/pause nobody sees beats sniffing for Safari.

     play() can still be rejected (low power mode, for one), so a rejection
     re-arms the flag and a one-shot touchstart tries again on the first real
     interaction. */
  const primeDecoder = () => {
    if (primed) return;
    primed = true;

    const started = video.play();
    if (started && typeof started.then === 'function') {
      started.then(() => {
        video.pause();
        updateScrub();
      }).catch(() => {
        primed = false;
      });
      return;
    }

    try {
      video.pause();
    } catch (_error) {
      primed = false;
    }
  };

  const seekVideo = (time) => {
    if (!duration || Number.isNaN(time)) return;
    const nextTime = clamp(time, 0, Math.max(0, duration - 0.035));
    if (Math.abs(video.currentTime - nextTime) < 0.025) return;
    try {
      video.currentTime = nextTime;
    } catch (_error) {
      // Seeks can be rejected before enough metadata has arrived.
    }
  };

  const updateScrub = () => {
    ticking = false;

    const rect = video.getBoundingClientRect();
    const viewport = window.innerHeight || 0;
    if (!rect.height || !viewport) return;

    /* Prime as it approaches rather than on load, so a page carrying several of
       these does not start every decoder at once on a phone. One viewport of
       margin is enough to be ready before the rotation is asked for. */
    if (!primed && rect.top < viewport * 2 && rect.bottom > -viewport) {
      primeDecoder();
    }

    if (!duration) return;

    /* Runs from the element being half on screen to it being centred, which
       works out at exactly half a viewport of scroll whatever the element's
       height.

       Both ends of this have been wrong once. Across a full pass, the last
       frames only arrived after the element had left the top of the viewport,
       so the end of the rotation was never seen. Starting from the top edge
       entering the viewport instead spent the opening frames below the fold
       and lost the beginning. Half-visible to centred keeps both: the rotation
       starts as the product appears and finishes with it settled and fully in
       view, then holds the last frame. */
    const start = viewport - (rect.height / 2);
    const travel = viewport / 2;
    const progress = clamp((start - rect.top) / Math.max(1, travel));
    seekVideo(progress >= 0.995 ? Math.max(0, duration - 0.035) : progress * duration);
  };

  const requestScrubUpdate = () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(updateScrub);
  };

  const initScrub = () => {
    duration = video.duration || 0;
    if (!duration) return;
    video.pause();
    updateScrub();
  };

  if (video.readyState >= 1) {
    initScrub();
  } else {
    video.addEventListener('loadedmetadata', initScrub, { once: true });
  }

  /* loadedmetadata can fire on iOS with no decoded frame yet, so re-run once a
     frame actually exists. Without this the first seek lands before there is
     anything to paint and the rotation appears to start late. */
  video.addEventListener('loadeddata', () => {
    if (!duration) initScrub();
    updateScrub();
  }, { once: true });

  // Last resort if autoplay-to-prime was refused: the first touch is a gesture.
  document.addEventListener('touchstart', () => {
    if (!primed) primeDecoder();
  }, { once: true, passive: true });

  window.addEventListener('scroll', requestScrubUpdate, { passive: true });
  window.addEventListener('resize', requestScrubUpdate);
  window.addEventListener('load', requestScrubUpdate);
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

/* WindowCAD reads its `tracking` parameter once, when the embed session starts,
   and never looks at the URL again. So the stamp the frame was loaded with is
   the stamp the finished quote arrives with, and it has to keep matching what
   the visitor actually chose.

   Until 2026-08-09 it did not. `loadQuoteFrame` wrote the stamped URL back over
   `data-quote-iframe-src` and `data-quote-url`, destroying the pristine address,
   and the consent listener below skipped any frame that already had a `src`. A
   visitor who chose "necessary only", got a frame stamped `rejected-cookies` and
   then changed their mind in the footer kept that stamp for the rest of the
   session: their journey id, their links and their consent record all updated
   around a frame that was still telling the office they had refused. Every quote
   completed that way was filed against a choice they had already reversed.

   The two source attributes are now left alone, exactly as `refreshWindowCadLinks`
   leaves `dataset.fgQuoteBaseUrl` alone, so the stamp can always be re-derived
   from the address the page was served with. */
const engagedQuoteFrames = new WeakSet();

const quoteFrameTrackedUrl = (frameWrap) => windowCadUrlWithReference(
  frameWrap?.querySelector('iframe[data-quote-iframe-src]')?.getAttribute('data-quote-iframe-src')
    || frameWrap?.getAttribute('data-quote-url')
    || '',
);

/* THE QUOTE EMBED IS NOT GATED ON CONSENT, and that is a deliberate exception
   to the consent model rather than an oversight.

   Three reasons, and the third is the one that decides it. The tool is the
   service the page exists to provide, so loading it is what the visitor came
   for. Its URL carries no identifier without consent — `windowCadUrlWithReference`
   stamps `cookie-consent-not-accepted` or the URL-derived ad reference, neither
   of which is stored on the device. And there is no placeholder UI for a waiting
   state: gating it would leave an unexplained empty panel on every product page,
   while building a load button back would breach the standing rule in `AI.md`
   against exactly that.

   What IS gated is the measurement. `trackWebsiteEvent` below still records
   nothing until consent, so an ungated embed produces an aggregate total and no
   journey. If the owner later wants the frame held back until a choice, the gate
   goes here and it needs a designed placeholder first. */
const loadQuoteFrame = (frameWrap) => {
  const quoteIframe = frameWrap?.querySelector('iframe[data-quote-iframe-src]');
  const quoteSrc = quoteIframe?.getAttribute('data-quote-iframe-src');

  if (!quoteIframe || !quoteSrc || quoteIframe.getAttribute('src')) {
    return;
  }

  delete frameWrap.dataset.quoteWaitingForConsent;
  const trackedQuoteSrc = windowCadUrlWithReference(quoteSrc);
  quoteIframe.setAttribute('src', trackedQuoteSrc);
  trackWebsiteEvent('quote_iframe_loaded', {
    cta: 'Embedded instant quote',
    product_collection: new URL(trackedQuoteSrc).searchParams.get('productCollection') || '',
  });
  frameWrap.classList.add('is-loaded');
};

/* Re-stamp a frame that is already loaded, because the visitor has just changed
   what we are allowed to know about them.

   Reloading the embed throws away whatever has been configured in it, so it only
   happens while the tool is untouched. Once somebody is part way through a job,
   the half-built quote is worth more than the attribution row and the frame is
   left where it is; the links and the expand/new-tab URL around it still get
   corrected. Same order of priorities as the non-blocking Meta relay: losing an
   attribution row costs a row, losing the lead costs the job. */
const restampQuoteFrame = (frameWrap) => {
  const quoteIframe = frameWrap?.querySelector('iframe[data-quote-iframe-src]');
  const loadedSrc = quoteIframe?.getAttribute('src');
  if (!loadedSrc || engagedQuoteFrames.has(frameWrap)) return;

  const trackedQuoteSrc = quoteFrameTrackedUrl(frameWrap);
  if (!trackedQuoteSrc || trackedQuoteSrc === loadedSrc) return;

  quoteIframe.setAttribute('src', trackedQuoteSrc);
  /* The first load happened without consent, so it was only ever counted as an
     aggregate total. Record the open against the journey the visitor now has,
     or the funnel loses the step entirely for everyone who accepts late. */
  trackWebsiteEvent('quote_iframe_loaded', {
    cta: 'Embedded instant quote',
    product_collection: new URL(trackedQuoteSrc).searchParams.get('productCollection') || '',
  });
};

const scheduleQuoteFrameLoad = (frameWrap, delay = 0) => {
  if (!frameWrap || frameWrap.dataset.quoteLoadScheduled === 'true') return;
  // Ungated for the reasons on `loadQuoteFrame` above.
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

/* A click that lands inside a cross-origin iframe is invisible to us, except
   that the window loses focus while the iframe becomes the active element. That
   is the same tell the tool cue uses further down to stop the ghost hand, and it
   is what keeps `restampQuoteFrame` from reloading a quote somebody is building.
   The pointer press is the cheaper half of the pair; the placeholder's own
   buttons are excluded, since pressing "Load quote tool" is not touching it. */
const quoteFrames = [...document.querySelectorAll('[data-quote-frame-wrap]')];

quoteFrames.forEach((frameWrap) => {
  frameWrap.addEventListener('pointerdown', (event) => {
    if (event.target.closest('button, a')) return;
    if (!frameWrap.querySelector('iframe[src]')) return;
    engagedQuoteFrames.add(frameWrap);
  });
});

window.addEventListener('blur', () => {
  const active = document.activeElement;
  if (active?.tagName !== 'IFRAME') return;
  const frameWrap = active.closest('[data-quote-frame-wrap]');
  if (frameWrap) engagedQuoteFrames.add(frameWrap);
});

window.addEventListener('fenster:cookie-preferences-updated', () => {
  quoteFrames.forEach((frameWrap) => {
    if (frameWrap.querySelector('iframe[src]')) {
      restampQuoteFrame(frameWrap);
      return;
    }
    if (!frameWrap.hasAttribute('data-quote-autoload')) return;
    delete frameWrap.dataset.quoteLoadScheduled;
    scheduleQuoteFrameLoad(frameWrap, frameWrap.dataset.quoteAutoload === 'idle' ? 150 : 0);
  });
});

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

    trackWebsiteEvent('quote_opened', { cta: (quoteLoadButton.textContent || 'Load quote tool').trim().slice(0, 120) });
    loadQuoteFrame(frameWrap);
  });
});

document.querySelectorAll('[data-fullscreen-quote]').forEach((quoteFullscreenButton) => {
  quoteFullscreenButton.addEventListener('click', async () => {
    const quoteCard = quoteFullscreenButton.closest('[data-quote-card]') || quoteFullscreenButton.closest('section') || document;
    const frameWrap = quoteCard.querySelector('[data-quote-frame-wrap]');
    /* Derived here rather than read off the wrapper. The attribute holds the
       address the page was served with, so the new-tab fallback used to open an
       unstamped WindowCAD session and lose the journey altogether. */
    const quoteUrl = quoteFrameTrackedUrl(frameWrap);

    trackWebsiteEvent('quote_opened', { cta: (quoteFullscreenButton.textContent || 'Expand quote tool').trim().slice(0, 120) });
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

/* ---- Settling the "this is live" cue on /online-quote/ ---------------------
   The embed reads as a screenshot until it is touched, so the frame carries a
   ring and a line telling the visitor to go straight in. Both stop the moment
   they do, because a cue that keeps insisting after it has been taken is noise.

   **A click inside a cross-origin iframe cannot be observed.** The window
   losing focus while that iframe is the active element is the standard proxy
   for it and is what this listens for, alongside a pointerdown anywhere on the
   tool for the case where someone grabs the scrollbar or a control first.

   Deliberately does NOT fire `quote_opened`. That metric is the before-and-after
   for this exact change (21 deliberate opens against 182 exposures in the 24
   days to 5 August 2026), and widening what counts as an open at the same time
   as trying to move it would make the comparison meaningless. */
const toolCue = document.querySelector('[data-fg-tool-cue]');

if (toolCue) {
  const settleToolCue = () => toolCue.classList.add('is-engaged');

  window.addEventListener('blur', () => {
    const active = document.activeElement;
    if (active && active.tagName === 'IFRAME' && toolCue.contains(active)) {
      settleToolCue();
    }
  });

  toolCue.addEventListener('pointerdown', settleToolCue);
}

/* ---- The mechanism is drawn in by the scroll on /casement-windows/ ----------
   The lock photograph comes in from the left as the security chapter rises
   through the viewport. Owner instruction, 2026-08-05: the first version fired
   once on a threshold and read like a slide transition, so the scroll is the
   timeline now. The part is wherever the scroll has put it, it reverses when you
   scroll back, and there is nothing to trigger or to miss.

   Written as a custom property on a wrapper, with the drift staying on the image
   inside it, so the two never share a transform. There is no CSS transition on
   the wrapper on purpose: the position is recomputed each scroll event, and a
   transition on top would lag behind the cursor.

   Eased out rather than linear, so it decelerates onto its mark instead of
   tracking the scrollbar one to one, which is the difference between a part
   settling and a layer sliding.

   Reduced motion is never attached, so the part simply sits where it belongs. */
const lockArrive = document.querySelector('[data-fg-lock-arrive]');

if (lockArrive && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const LOCK_TRAVEL = 26;   // per cent of its own width

  const updateLockArrive = () => {
    const rect = lockArrive.getBoundingClientRect();
    const viewport = Math.max(1, window.innerHeight);
    /* Nought while the part is still below the fold, one by the time it has
       risen to a little above the middle, so it is settled before it is the
       thing you are looking at rather than still moving under the eye. */
    const from = viewport;
    const to = viewport * 0.42;
    const progress = clamp((from - rect.top) / Math.max(1, from - to), 0, 1);
    const eased = 1 - Math.pow(1 - progress, 3);
    lockArrive.style.setProperty('--fg-lock-x', `${((eased - 1) * LOCK_TRAVEL).toFixed(2)}%`);
  };

  window.addEventListener('scroll', updateLockArrive, { passive: true });
  window.addEventListener('resize', updateLockArrive);
  updateLockArrive();
}

/* ---- Stacked chapters on /casement-windows/ ---------------------------------
   Chapters 01, 02 and 03 read as physical panels: each one anchors at the foot of
   the viewport once it has been scrolled through, and the next slides up over it.

   The movement itself is `position: sticky` in CSS, so the browser owns it and it
   stays smooth in both directions with no animation loop. This file supplies the
   two things CSS cannot work out for itself.

   1. The sticky offset. These panels run two to three viewports tall, so the
      offset has to be a *negative* top of `viewport - panel height`: a `top`
      constraint only ever pushes a box down, so the panel scrolls normally
      through its content and pins exactly as its bottom edge reaches the bottom
      of the screen. `top: 0` would freeze each panel after one screenful and
      `bottom: 0` drags the later panels up onto the first one from the first
      paint. Both were measured before this settled on the negative offset.
   2. The dim on the panel being covered, which is what stops it reading as a hole
      behind the incoming one and makes the two feel like layers rather than a cut.

   Heights are re-measured through a ResizeObserver rather than on load alone,
   because these panels contain lazy images and an accordion and their height is
   not final when the script first runs. Progress for the dim is taken from the
   incoming panel's top edge, so it is scroll-linked rather than time-linked: it
   is exact in both directions, cannot drift, and can be checked by measurement
   rather than by watching, which matters because rAF is throttled in every
   harness this project has (see nick.md).

   `is-stacked` is added only once a real measurement exists, so with JavaScript
   off, or under reduced motion, the chapters stay in ordinary document flow. */
const chapterStack = document.querySelector('[data-fg-chapter-stack]');

if (chapterStack && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const stackPanels = [...chapterStack.querySelectorAll('.fg-cas-stack__panel')];
  const narrowStack = window.matchMedia('(max-width: 860px)');
  let stackFrame = 0;

  // Pin point per panel. Re-read on resize and whenever a panel's own height
  // changes; both are rare, and neither happens per frame.
  const siteHeader = document.querySelector('.site-header');

  const measureChapterStack = () => {
    const viewport = Math.max(1, window.innerHeight);
    // The header is sticky on desktop and fixed on mobile, so a panel pinned at
    // zero puts its own first line behind it. Short panels stop just below it.
    const headerHeight = siteHeader ? Math.round(siteHeader.getBoundingClientRect().height) : 0;

    stackPanels.forEach((panel) => {
      const height = panel.getBoundingClientRect().height;
      // Taller than the screen, which is the case for the three chapters, pins by
      // the bottom edge: `viewport - height` is negative and a `top` constraint
      // only ever pushes a box down, so the panel reads in full first. Shorter
      // than the screen, which the film plate is, pins under the header instead.
      const offset = Math.min(headerHeight, viewport - height);
      panel.style.setProperty('--fg-stack-top', `${Math.round(offset)}px`);
    });

    if (stackPanels.length) {
      chapterStack.classList.add('is-stacked');
    }
  };

  const updateChapterStack = () => {
    stackFrame = 0;
    // Restrained on a phone, where the panels meet in a much narrower frame and
    // a full-strength dim reads as the screen going out rather than as depth.
    const maxDim = narrowStack.matches ? 0.16 : 0.32;
    const viewport = Math.max(1, window.innerHeight);

    stackPanels.forEach((panel, index) => {
      const incoming = stackPanels[index + 1];

      // The last panel is never covered.
      if (!incoming) {
        panel.style.setProperty('--fg-stack-dim', '0');
        return;
      }

      // 0 when the incoming panel's top edge is at the bottom of the viewport,
      // 1 once it has reached the top and is covering completely.
      const covered = clamp(1 - (incoming.getBoundingClientRect().top / viewport));
      panel.style.setProperty('--fg-stack-dim', (covered * maxDim).toFixed(3));
    });
  };

  const requestChapterStackUpdate = () => {
    if (!stackFrame) {
      stackFrame = requestAnimationFrame(updateChapterStack);
    }
  };

  const remeasureChapterStack = () => {
    measureChapterStack();
    requestChapterStackUpdate();
  };

  measureChapterStack();
  requestChapterStackUpdate();

  window.addEventListener('scroll', requestChapterStackUpdate, { passive: true });
  window.addEventListener('resize', remeasureChapterStack);
  window.addEventListener('load', remeasureChapterStack);

  if ('ResizeObserver' in window) {
    // Measuring the panel we are about to resize would loop, so the callback is
    // deferred a frame and only writes when the value actually moves.
    const stackObserver = new ResizeObserver(() => {
      if (!stackFrame) {
        stackFrame = requestAnimationFrame(() => {
          measureChapterStack();
          updateChapterStack();
        });
      }
    });

    stackPanels.forEach((panel) => stackObserver.observe(panel));
  }
}

/* ---- Key specifications: the values arrive on a drum --------------------------
   Each value is revealed the way a mechanical counter settles rather than by
   fading in. It runs once, when the strip first reaches the viewport, and the
   strip is completely static before and after.

   Two things make it a counter rather than a number that changes.

   It only ever steps by one. The readings walk the last decimal place a single
   unit at a time, so counting onto 0.95 reads 1.00, 0.99, 0.98, 0.97, 0.96,
   0.95 and every numeral in between is actually on screen. Spacing a fixed
   number of readings evenly across the range instead, which is what this did
   before, jumps five or six hundredths a step: the run ends by flopping from
   1.0 straight to 0.95, and 2.2 never shows 0.5, 1.2 or 1.9 at all. Nothing
   mechanical skips.

   The wheels are faces on a cylinder and the cylinder turns. A digit wheel is
   the full ten faces, 0 through 9, spaced the way a real one is: the window is
   one face tall, so the drum is 36 degrees per digit and whatever is at the
   window sits at rotateX(0), lies flat and renders sharp. Because the readings
   step by one, every wheel advances exactly one face per click and always in
   the same direction, so a fast wheel simply turns through several complete
   revolutions. The previous version gave each cell a tilt fixed for the whole
   run, which meant a cell crossed the window permanently foreshortened: that
   is distortion, not rotation, and it is what made the digits look bent.

   Each wheel is driven by its own keyframes, and that is why this is not a CSS
   transition. A transition moves a wheel continuously from its first cell to
   its last over the whole run, so a column that is mostly the same digit still
   scrolls a stack of identical glyphs past the window and reads as permanently
   drifting. On a real odometer the tens wheel does not creep while the units
   spins: it sits dead still and rotates once, at the carry. So a wheel is given
   keyframes that hold, click, hold, its column collapsed to the readings where
   that digit actually changes.

   Deceleration lives in the timing, which is again where a counter puts it. The
   gaps between readings grow geometrically, so the drum opens fast and the last
   few clicks are slow enough to read one at a time.

   The markup is restored to plain text once everything settles, which returns
   the strip byte-for-byte to what it was, drops the mask off the resting value
   and leaves nothing animating. */
const pulseStrips = [...document.querySelectorAll('.fg-product-pulse')];

if (pulseStrips.length
  && 'IntersectionObserver' in window
  && typeof Element.prototype.animate === 'function') {
  const pulseReduce = window.matchMedia('(prefers-reduced-motion: reduce)');

  const PULSE_MS_PER_CLICK = 69;   // before the caps below
  const PULSE_MS_MIN = 900;
  const PULSE_MS_MAX = 1800;
  const PULSE_STAGGER = 150;       // between tiles
  /* Single-unit steps mean the range is a click count. Long enough that the
     higher columns carry the way a real counter does, short enough that the
     opening is quick rather than a blur: 26 hundredths takes 0.95 back past
     1.00, so the units wheel turns once and the tenths three times.

     Measured against the brake below, this opens at 32ms a click and closes at
     127ms. 34 was tried first and opens at 19ms, which is a single frame at
     60Hz and reads as the blur the owner had already objected to. */
  const PULSE_MAX_CLICKS = 26;
  const PULSE_MIN_CLICKS = 3;      // fewer than this and there is nothing to count
  const PULSE_BRAKE = 4;           // last gap over first gap
  const PULSE_FACES = 10;          // digits on a wheel
  const PULSE_ANGLE = 360 / PULSE_FACES;
  const PULSE_CLICK = 'cubic-bezier(0.45, 0, 0.15, 1)';
  const PULSE_CLICK_MS = 130;      // longest a single click may take
  const PULSE_NUMBER = /\d+(?:\.\d+)?/;
  /* A number sitting immediately after an acronym is part of a name, not a
     quantity: PAS 24, RAL 7016, BS EN 1670. Those must not count, because
     counting them invents standards and colours that do not exist. Anything
     else does count, including a number introduced by an ordinary word, so
     "Up to 7 panes" and "From 1.8 W/m²K" turn like any other readout. */
  const PULSE_NAMED = /(?:^|\s)[A-Z]{2,}\.?\s*$/;
  /* Tiles that never count, by label. Owner instruction, 2026-08-05: interlock,
     outer frame and sightlines are not to animate on any product. They are
     system dimensions rather than quantities of anything, so counting up to one
     says nothing, and "80mm or 52mm" is a choice between two specifications
     rather than a number with a value in between. Matched on letters alone, as
     the U-value label is, because these render with a non-breaking hyphen.

     Sightlines is the only one of the three that reads as a quantity, which is
     why it was counting: 60.5mm on heritage doors is the width of the frame you
     see, and a slimmer one is the better one, so winding up to it says the
     opposite of what the number means. The other four routes carrying the label
     say "Ultra slim" or "Slimmer" and never had a digit to count. */
  const PULSE_STATIC = /^(?:interlock|outerframe|sightlines)$/i;

  /* When each reading lands, as a fraction of the run. The gaps grow by a fixed
     ratio, so the drum brakes onto its figure instead of clicking at a constant
     rate. Ends at exactly 1 by construction. */
  const pulseSchedule = (total) => {
    const times = [0];
    if (total <= 0) return times;
    if (total === 1) return [0, 1];

    const ratio = Math.pow(PULSE_BRAKE, 1 / (total - 1));
    const sum = (Math.pow(ratio, total) - 1) / (ratio - 1);
    for (let step = 1; step <= total; step += 1) {
      times.push(((Math.pow(ratio, step) - 1) / (ratio - 1)) / sum);
    }
    return times;
  };

  /* The readings, one unit of the last decimal place apart.

     No reading ever passes the target, so a figure we do not claim is never on
     screen: counting up approaches from below and stops, counting down from
     above and stops. A wheel is only as wide as the digit that lands, so
     counting down is capped at the largest number of the same digit count and
     0.95 cannot start at 10.65. Deterministic throughout, no Math.random, so
     the same page produces the same readings twice and measuring it means
     something. */
  const pulseSequence = (numberText, descending) => {
    const target = parseFloat(numberText);
    if (!Number.isFinite(target) || target === 0) return null;

    const decimals = (numberText.split('.')[1] || '').length;
    const unit = Math.pow(10, -decimals);
    // Counted in units of the last decimal place, so every step is an integer
    // and the readings cannot drift on binary floating point.
    const landing = Math.round(target / unit);
    const digits = Math.floor(Math.abs(target)).toString().length;
    const ceiling = Math.round(Math.pow(10, digits) / unit) - 1;

    /* Counting down is held to twice the figure as well as to the click cap.
       Without it a tenth-place value takes the full 26 clicks and a 1.2 W/m²K
       tile opens on 3.8, which is a believable reading of a bad window rather
       than an obvious counter winding up. Hundredths are unaffected: 0.95 is
       capped by the clicks, not by this. */
    const clicks = descending
      ? Math.min(PULSE_MAX_CLICKS, ceiling - landing, landing)
      : Math.min(PULSE_MAX_CLICKS, landing - 1);

    // A value one or two clicks from its start has nothing worth watching, and
    // counting 1 onto the screen would have to show a 0 we do not claim.
    if (clicks < PULSE_MIN_CLICKS) return null;

    const readings = [];
    for (let step = 0; step <= clicks; step += 1) {
      const at = descending ? landing + (clicks - step) : landing - clicks + step;
      readings.push((at * unit).toFixed(decimals));
    }
    // The last reading is the value itself, exactly as it is written on the page.
    readings[clicks] = numberText;

    return {
      readings,
      duration: Math.min(PULSE_MS_MAX, Math.max(PULSE_MS_MIN, clicks * PULSE_MS_PER_CLICK)),
    };
  };

  /* Offsets must strictly increase or the animation is rejected. Nudging is
     safe: a pair this close is a click too short to see anyway. */
  const pulseTidyFrames = (frames) => {
    let previous = -1;
    return frames.map((frame) => {
      const offset = Math.min(1, Math.max(previous + 0.0001, frame.offset));
      previous = offset;
      return { ...frame, offset };
    }).filter((frame) => frame.offset <= 1);
  };

  const revealPulseValue = (el, order) => {
    const finalText = (el.textContent || '').trim();
    if (finalText === '') return 0;

    /* The U-value is the one figure on the strip where lower is better, so it
       counts down onto its figure and arrives from above.

       Read off the tile's own label rather than the `__glazing-rows` wrapper.
       That wrapper only exists where product-pulse.php finds the route in
       `glazing_u_values`, and uPVC doors and patio doors are deliberately not in
       it, so their U-value renders through the plain branch. Keyed on the
       wrapper alone those two counted upward: 0.1, 0.2 ... 0.9 before landing on
       1.0, putting whole-window U-values better than anything achievable on
       screen for the length of the run, on the one figure where lower is
       better. Every U-value tile is labelled "U-value", starred or not.

       Matched on letters alone because the label renders with a non-breaking
       hyphen, U+2011, not an ASCII one, so /^u-value/ does not match it. */
    const tile = el.closest('li');
    const tileLabel = tile && tile.querySelector('small')
      ? (tile.querySelector('small').textContent || '')
      : '';
    const tileWord = tileLabel.replace(/[^a-z]/gi, '');

    // Left exactly as served, and not counted toward the stagger either, so the
    // tiles that do run still arrive in an unbroken sequence.
    if (PULSE_STATIC.test(tileWord)) return 0;

    const descending = Boolean(el.closest('.fg-product-pulse__glazing-rows'))
      || /^uvalue/i.test(tileWord);
    // Which way the drum turns. Counting up, the next digit rises into the
    // window from below; counting down it drops in from above.
    const spin = descending ? -1 : 1;

    /* The window is one line tall, so a wheel sits on the text baseline beside
       the characters that are not moving rather than forming a block. */
    const lineHeight = parseFloat(getComputedStyle(el).lineHeight)
      || el.getBoundingClientRect().height;
    if (!lineHeight) return 0;

    /* Split into alternating text and numbers. Every number is treated on its
       own, so "2.2m x 1m" runs both of them. */
    const segments = [];
    const finder = new RegExp(PULSE_NUMBER.source, 'g');
    let cursor = 0;
    let found = finder.exec(finalText);

    while (found !== null) {
      if (found.index > cursor) segments.push({ text: finalText.slice(cursor, found.index) });
      // Everything to the left decides whether this number is a quantity or
      // part of a name, so it travels with it.
      segments.push({ number: found[0], before: finalText.slice(0, found.index) });
      cursor = found.index + found[0].length;
      found = finder.exec(finalText);
    }
    if (cursor < finalText.length) segments.push({ text: finalText.slice(cursor) });

    const shell = document.createElement('span');
    shell.setAttribute('aria-hidden', 'true');
    const animations = [];

    /* One duration for the whole value, taken from its longest count, so a value
       holding two numbers lands both at once. Timed separately, "6.5m wide, 2.5m
       tall" settled its height 138ms before its width. */
    const plans = segments.map((segment) => (
      segment.text !== undefined || PULSE_NAMED.test(segment.before)
        ? null
        : pulseSequence(segment.number, descending)
    ));
    const duration = plans.reduce((slowest, plan) => (
      plan ? Math.max(slowest, plan.duration) : slowest
    ), 0);
    const clickMax = duration ? PULSE_CLICK_MS / duration : 0;

    /* A wheel needs an explicit width, because every face is taken out of flow
       to sit on the cylinder and an empty box would collapse. The width is the
       widest face it will show, measured here in the real inherited font rather
       than assumed: Gibson has no tabular figures, so a 1 is 7.5px where every
       other digit is 10.03px, and a wheel sized on a 1 would clip the digits
       that follow it.

       Measured once per value off a probe rather than by leaving one face in
       flow to do the sizing. That was tried and is subtly wrong: an in-flow cell
       inside the preserve-3d stack does not take its translateZ, so it stays at
       the window instead of going round to its place on the drum and paints on
       top of whatever face is actually showing. Measured, it sat at dy=-0.1
       where the cylinder puts it at -19.1. */
    const gauge = document.createElement('span');
    gauge.style.cssText = 'position:absolute;visibility:hidden;white-space:pre';
    el.appendChild(gauge);
    const glyphWidth = {};
    '0123456789 '.split('').forEach((glyph) => {
      gauge.textContent = glyph;
      glyphWidth[glyph] = gauge.getBoundingClientRect().width;
    });
    el.removeChild(gauge);

    segments.forEach((segment, index) => {
      if (segment.text !== undefined) {
        shell.appendChild(document.createTextNode(segment.text));
        return;
      }

      // Part of a name rather than a quantity: render it and leave it alone.
      const counted = plans[index];

      if (!counted) {
        shell.appendChild(document.createTextNode(segment.number));
        return;
      }

      /* Every digit is its own inline-block, and a line break is allowed between
         adjacent inline-blocks, so without this a figure could split across two
         lines mid-number for the length of the run and then reflow when it
         settles: "6.5m wide, 2.5m tall" breaking as "2." / "5m tall". The box is
         per number, not around the whole value, so the ordinary break
         opportunities between words survive. */
      const figure = document.createElement('span');
      figure.className = 'fg-pulse-figure';
      shell.appendChild(figure);

      const { readings } = counted;
      const total = readings.length - 1;
      const times = pulseSchedule(total);

      /* Readings are padded on the left, because a counter aligns on its units.
         A shorter reading leaves that column blank, so the tens wheel of "16"
         arrives partway through rather than showing a leading zero. */
      const width = segment.number.length;
      const padded = readings.map((reading) => reading.padStart(width, ' '));

      for (let column = 0; column < width; column += 1) {
        const chars = padded.map((reading) => reading[column]);
        const settledChar = segment.number[column];

        /* Collapse the column to the readings where it actually changes. This
           is what makes a wheel a wheel: its stops are its own, not the run's. */
        const stops = [];
        chars.forEach((char, index) => {
          if (index === 0 || char !== chars[index - 1]) stops.push({ char, at: index });
        });

        // A decimal point, or a digit that never changes: nothing to turn.
        if (!/\d/.test(settledChar) || stops.length < 2) {
          figure.appendChild(document.createTextNode(settledChar));
          continue;
        }

        const clicks = stops.length - 1;

        /* A column that steps a single digit at a time, which after the change
           above is every column that never went blank, is a real ten-face wheel
           and can turn as many revolutions as it likes. The one that does go
           blank is the leading column of a value like 16, which has no wheel to
           model: it gets a face per stop instead, spaced the same way. */
        const stepwise = stops.every((stop, index) => index === 0 || (
          /\d/.test(stop.char)
          && /\d/.test(stops[index - 1].char)
          && ((((Number(stop.char) - Number(stops[index - 1].char)) * spin) % 10) + 10) % 10 === 1
        ));

        const faces = [];
        if (stepwise) {
          const first = Number(stops[0].char);
          for (let face = 0; face < PULSE_FACES; face += 1) {
            faces.push(String((((first + (spin * face)) % 10) + 10) % 10));
          }
        } else {
          stops.forEach((stop) => faces.push(stop.char));
        }

        /* Faces touch on the surface, so a window one face tall makes the drum
           exactly 36 degrees per digit, which is what a real counter is. A real
           wheel is meant to close on itself at 360, so the ten-face drum takes
           that angle as given and simply turns through as many revolutions as
           the count needs. Only the odd blank-led wheel, which is not a wheel
           anybody makes, has to be checked: faces further apart than 360/n would
           put two of them in the same place and they would fight. */
        const angle = stepwise ? PULSE_ANGLE : Math.min(PULSE_ANGLE, 355 / faces.length);
        const radius = (lineHeight / 2) / Math.tan((angle * Math.PI) / 360);
        /* The drum is pushed back by its own radius so the face at the window
           lands on the screen plane. A settled digit is then unscaled and
           pixel-identical to the plain text that replaces it. */
        const position = (click) => `translateZ(${(-radius).toFixed(2)}px) rotateX(${(spin * click * angle).toFixed(2)}deg)`;

        const reel = document.createElement('span');
        reel.className = 'fg-pulse-reel';
        reel.style.setProperty('--fg-reel-h', `${lineHeight}px`);

        const stack = document.createElement('span');
        stack.className = 'fg-pulse-reel__stack';
        // Resting state is the settled digit, so a wheel that never runs still
        // shows the right character.
        stack.style.transform = position(clicks);

        /* The window is exactly as wide as the digit that LANDS, not as wide as
           the widest face it will show. Gibson's 1 is 8.61px against 11.52px for
           every other digit at this size, so a wheel landing on a 1 and sized on
           its widest face is 2.91px too wide: "1.1 W/m²K" renders as "1 . 1" for
           the whole run and then snaps 5.82px left the instant the plain text
           comes back. Sized on the landing digit, the settled shell is the same
           width as the text it replaces and nothing moves. Wider faces overhang
           while they pass, which is why the reel clips vertically only. */
        reel.style.width = `${(glyphWidth[settledChar] || 0).toFixed(2)}px`;

        faces.forEach((face, index) => {
          const cell = document.createElement('span');
          cell.className = 'fg-pulse-reel__cell';
          cell.textContent = face;
          cell.style.transform = `rotateX(${(-spin * index * angle).toFixed(2)}deg) translateZ(${radius.toFixed(2)}px)`;
          stack.appendChild(cell);
        });

        reel.appendChild(stack);
        figure.appendChild(reel);

        /* Hold, click, hold. Each rotation is scheduled at the moment its digit
           actually changes and takes only a slice of the gap before it, so the
           wheel is motionless the rest of the time. */
        const frames = [{ offset: 0, transform: position(0), easing: 'linear' }];
        let previousTime = 0;

        for (let click = 1; click <= clicks; click += 1) {
          const at = stops[click].at;
          const time = times[at];
          /* A click takes a slice of the single reading it lands on, never of
             this wheel's own gap since its last one. That is what makes a carry
             a carry: the tens turns during the same click that takes the units
             past 9, so both cross together. Timed off the wheel's own gap
             instead, a wheel that had been still for ten readings began turning
             130ms early and was already showing its new digit while the one
             below it was still counting down, which put 1.12 between 1.22 and
             1.19, and 0.90 between 1.00 and 0.99. */
          const span = Math.max(0.0002, time - times[Math.max(0, at - 1)]);
          const turn = Math.min(span * 0.55, clickMax);

          frames.push({ offset: Math.max(previousTime, time - turn), transform: position(click - 1), easing: PULSE_CLICK });
          frames.push({ offset: time, transform: position(click), easing: 'linear' });
          previousTime = time;
        }

        frames.push({ offset: 1, transform: position(clicks), easing: 'linear' });

        animations.push(stack.animate(pulseTidyFrames(frames), {
          duration,
          delay: order * PULSE_STAGGER,
          easing: 'linear',
          fill: 'both',
        }));
      }
    });

    if (!animations.length) return 0;

    // The true value stays in the accessible tree throughout; the wheels and the
    // static text around them are hidden from it, so no intermediate reading is
    // ever announced and the value is never announced twice.
    const spoken = document.createElement('span');
    spoken.className = 'fg-product-pulse__sr';
    spoken.textContent = finalText;

    el.textContent = '';
    el.appendChild(spoken);
    el.appendChild(shell);

    let settled = false;
    const settle = () => {
      if (settled || !el.isConnected) return;
      settled = true;
      animations.forEach((animation) => animation.cancel());
      el.textContent = finalText;
    };

    Promise.all(animations.map((animation) => animation.finished))
      .then(settle)
      .catch(() => {});

    // finished does not resolve if the tab is hidden for the whole run.
    window.setTimeout(settle, (order * PULSE_STAGGER) + duration + 500);
    return 1;
  };

  const revealPulseStrip = (strip) => {
    const values = [...strip.querySelectorAll('li strong')];
    if (!values.length) return;

    // Reduced motion gets the static version, which here means the strip is
    // simply left alone. The values are already rendered, so doing nothing is
    // both the least motion and the only option that cannot leave a
    // specification hidden if something later goes wrong.
    if (pulseReduce.matches) return;

    // The stagger counts revealed values, not tiles. A strip whose second tile
    // has nothing to count would otherwise leave a gap in the sequence and the
    // remaining tiles would arrive late for no visible reason.
    let revealed = 0;
    values.forEach((el) => {
      revealed += revealPulseValue(el, revealed);
    });
  };

  const pulseObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      // Once only: unobserve before revealing so a re-entry cannot restart it.
      pulseObserver.unobserve(entry.target);
      revealPulseStrip(entry.target);
    });
  }, { threshold: 0.25 });

  pulseStrips.forEach((strip) => pulseObserver.observe(strip));
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

// Case study hero videos: keep them muted, play only while in view and pause
// off-screen so we do not burn battery or data on a looping clip.
document.querySelectorAll('.fg-cs video').forEach((video) => {
  video.muted = true;
  const tryPlay = () => video.play().catch(() => {});
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          tryPlay();
        } else {
          video.pause();
        }
      });
    }, { threshold: 0.2 });
    observer.observe(video);
  } else {
    tryPlay();
  }
});

// Keep the archive compact while preserving the newest-first order from the
// case-study data. Older cards are only hidden once JavaScript is available,
// so the complete archive remains usable without it.
document.querySelectorAll('[data-fg-case-studies-archive]').forEach((archive) => {
  const cards = [...archive.querySelectorAll('[data-fg-case-study-card]')];
  const moreButton = archive.parentElement?.querySelector('[data-fg-case-studies-more]');
  const initialCount = Number.parseInt(archive.dataset.fgCaseStudiesInitial || '4', 10);

  if (!moreButton || cards.length <= initialCount) return;

  const deferredCards = cards.slice(initialCount);
  deferredCards.forEach((card) => {
    card.hidden = true;
  });
  moreButton.hidden = false;
  moreButton.addEventListener('click', () => {
    deferredCards.forEach((card) => {
      card.hidden = false;
    });
    moreButton.remove();
  });
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


// About page: deferred install videos and gentle scroll reveals.
document.querySelectorAll('.fg-about').forEach((about) => {
  const aboutReduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const aboutVideos = [...about.querySelectorAll('[data-fg-about-video]')];

  const attachAboutVideo = (video) => {
    if (video.dataset.fgVideoReady) return;
    // Background videos (the hero) stay a poster on mobile and for
    // reduced-motion users: no payload, no unreachable controls.
    if (video.hasAttribute('data-fg-video-bg')
      && (aboutReduceMotion || window.matchMedia('(max-width: 860px)').matches)) {
      return;
    }
    video.dataset.fgVideoReady = 'true';
    [...video.querySelectorAll('source[data-src]')].forEach((source) => {
      source.src = source.getAttribute('data-src');
    });
    if (aboutReduceMotion) {
      video.controls = true;
      video.preload = 'metadata';
      video.load();
      return;
    }
    video.load();
    const playAttempt = video.play();
    if (playAttempt && typeof playAttempt.catch === 'function') {
      playAttempt.catch(() => {
        video.controls = true;
      });
    }
  };

  if (aboutVideos.length) {
    if ('IntersectionObserver' in window) {
      const aboutVideoObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          attachAboutVideo(entry.target);
          aboutVideoObserver.unobserve(entry.target);
        });
      }, { rootMargin: '260px 0px' });
      aboutVideos.forEach((video) => aboutVideoObserver.observe(video));
    } else {
      aboutVideos.forEach(attachAboutVideo);
    }
  }

  const aboutRevealItems = [...about.querySelectorAll('[data-fg-about-reveal]')];
  if (!aboutRevealItems.length) return;

  if (aboutReduceMotion || !('IntersectionObserver' in window)) {
    aboutRevealItems.forEach((item) => item.classList.add('is-visible'));
    return;
  }

  about.classList.add('fg-about-motion');

  // The huge top margin keeps anything at or above the viewport "intersecting",
  // so a fast scroll cannot jump an element past the observer and leave it
  // permanently hidden.
  const aboutRevealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-visible');
      aboutRevealObserver.unobserve(entry.target);
    });
  }, {
    rootMargin: '100000px 0px -10% 0px',
    threshold: 0.12,
  });

  aboutRevealItems.forEach((item) => aboutRevealObserver.observe(item));
});

/* Colour hub rail. Native scroll-snap, so the buttons scroll the viewport
   rather than driving a separate index: a swipe and a button press can never
   disagree about where the rail is. Replaced the coverflow on 2026-07-29.
   The coverflow controller above is still live for the heritage door
   configurations, which share .fg-colour-carousel. */
document.querySelectorAll('[data-fg-colour-rail]').forEach((rail) => {
  const viewport = rail.querySelector('[data-fg-colour-rail-viewport]');
  const slides = [...rail.querySelectorAll('[data-fg-colour-slide]')];

  if (!viewport || !slides.length) return;

  // A native image drag beats any pointer handling, so switch it off first.
  viewport.querySelectorAll('img').forEach((img) => {
    img.draggable = false;
  });

  const step = () => {
    const a = slides[0];
    const b = slides[1];
    return b ? Math.abs(b.offsetLeft - a.offsetLeft) : a.getBoundingClientRect().width;
  };

  const scrollBySlides = (direction) => {
    viewport.scrollBy({ left: step() * direction, behavior: 'smooth' });
  };

  /* Click-drag for a mouse. Touch and trackpad already scroll natively, so
     this only claims the pointer once a drag has actually travelled: a plain
     click on a swatch must still behave like a click. Snapping is turned off
     mid-drag so the rail follows the hand rather than fighting it. */
  let dragging = false;
  let startX = 0;
  let startScroll = 0;
  let moved = 0;

  let lastX = 0;
  let lastT = 0;
  let velocity = 0;

  viewport.addEventListener('pointerdown', (event) => {
    if (event.pointerType === 'touch' || event.button !== 0) return;
    // Stops the browser starting its own text/image selection instead.
    event.preventDefault();
    dragging = true;
    moved = 0;
    velocity = 0;
    startX = event.clientX;
    lastX = event.clientX;
    lastT = event.timeStamp;
    startScroll = viewport.scrollLeft;
    viewport.style.scrollSnapType = 'none';
  });

  viewport.addEventListener('pointermove', (event) => {
    if (!dragging) return;
    const delta = event.clientX - startX;
    if (Math.abs(delta) > 3) {
      moved = Math.abs(delta);
      if (!viewport.classList.contains('is-dragging')) {
        viewport.classList.add('is-dragging');
        viewport.setPointerCapture?.(event.pointerId);
      }
      viewport.scrollLeft = startScroll - delta;
      const dt = event.timeStamp - lastT;
      if (dt > 0) velocity = (lastX - event.clientX) / dt;
      lastX = event.clientX;
      lastT = event.timeStamp;
    }
  });

  const nearestSlideOffset = (target) => {
    const base = slides[0].offsetLeft;
    let best = target;
    let bestGap = Infinity;
    slides.forEach((slide) => {
      const offset = slide.offsetLeft - base;
      const gap = Math.abs(offset - target);
      if (gap < bestGap) {
        bestGap = gap;
        best = offset;
      }
    });
    return best;
  };

  /* Let go and the rail carries on rather than stopping dead under the finger.
     How far it throws comes from how fast the drag was moving, and the travel
     is the browser's own smooth scroll rather than a hand-rolled animation
     loop: it keeps working when frames are throttled and it already honours a
     reduced-motion setting.

     It only lands on a slide when the throw already ended near one. Forcing
     the nearest slide every time was the grabby part: a small nudge got yanked
     to a boundary it was nowhere near. */
  const endDrag = (event) => {
    if (!dragging) return;
    dragging = false;
    viewport.classList.remove('is-dragging');
    if (event?.pointerId !== undefined) viewport.releasePointerCapture?.(event.pointerId);

    const max = Math.max(0, viewport.scrollWidth - viewport.clientWidth);
    const projected = viewport.scrollLeft + velocity * 140;
    const aligned = nearestSlideOffset(projected);
    // A third of a slide. Past that the throw keeps whatever it landed on.
    const pull = step() * 0.33;
    const wanted = Math.abs(aligned - projected) <= pull ? aligned : projected;
    const target = Math.max(0, Math.min(max, wanted));

    /* Snapping stays off until the scroll has finished, or it fights the
       animation and drops the rail back where the finger left it. */
    const restoreSnap = () => {
      viewport.style.scrollSnapType = '';
    };

    if (Math.abs(target - viewport.scrollLeft) < 1) {
      restoreSnap();
      return;
    }

    viewport.scrollTo({ left: target, behavior: 'smooth' });

    let settled = false;
    const finish = () => {
      if (settled) return;
      settled = true;
      viewport.removeEventListener('scrollend', finish);
      restoreSnap();
    };
    viewport.addEventListener('scrollend', finish);
    window.setTimeout(finish, 700);
  };

  viewport.addEventListener('pointerup', endDrag);
  viewport.addEventListener('pointercancel', endDrag);
  viewport.addEventListener('pointerleave', endDrag);

  // Suppress the click that ends a real drag, so dragging never opens anything.
  viewport.addEventListener('click', (event) => {
    if (moved > 4) {
      event.preventDefault();
      event.stopPropagation();
      moved = 0;
    }
  }, true);

  viewport.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowRight') {
      event.preventDefault();
      scrollBySlides(1);
    } else if (event.key === 'ArrowLeft') {
      event.preventDefault();
      scrollBySlides(-1);
    }
  });

  /* Deep links such as /colour-options/?material=upvc&colour=basalt-grey bring
     the swatch into the rail and the material section into the page. Carried
     over from the coverflow controller unchanged in behaviour: Lenis keeps the
     page pinned at the top while the hero images size, so it is paused, the
     jump is re-asserted a few times, then smooth scrolling is handed back. */
  try {
    const params = new URLSearchParams(window.location.search);
    const wantColour = params.get('colour');
    if (wantColour) {
      const material = rail.closest('[data-fg-colour-material]');
      const materialKey = material?.getAttribute('data-fg-colour-material') || '';
      const wantMaterial = params.get('material');
      if (!wantMaterial || wantMaterial === materialKey) {
        const target = slides.find((slide) => slide.getAttribute('data-colour-slug') === wantColour);
        if (target) {
          const section = material || rail;
          const lenis = window.fensterLenis;
          let cancelled = false;
          const release = () => {
            cancelled = true;
            lenis?.start?.();
          };
          ['wheel', 'touchstart', 'keydown', 'pointerdown'].forEach((eventName) => {
            window.addEventListener(eventName, release, { once: true, passive: true });
          });
          const settle = () => {
            if (cancelled) return;
            viewport.scrollLeft = Math.max(0, target.offsetLeft - viewport.offsetLeft);
            const y = Math.max(0, section.getBoundingClientRect().top + window.scrollY - 96);
            if (lenis?.scrollTo) {
              lenis.scrollTo(y, { immediate: true, force: true });
            } else {
              window.scrollTo(0, y);
            }
          };
          const run = () => {
            if (cancelled) return;
            lenis?.stop?.();
            settle();
            [120, 350, 700].forEach((delay) => window.setTimeout(() => {
              if (!cancelled) settle();
            }, delay));
            window.setTimeout(() => {
              if (!cancelled) {
                settle();
                lenis?.start?.();
              }
            }, 950);
          };
          if (document.readyState === 'complete') {
            window.setTimeout(run, 60);
          } else {
            window.addEventListener('load', () => window.setTimeout(run, 60), { once: true });
          }
        }
      }
    }
  } catch (error) {
    /* deep link is best-effort */
  }

});


/* Read more on the colour hub intro, phones only. The clamp is applied here
   rather than in the stylesheet so that a page without JavaScript shows the
   whole paragraph instead of a cut-off one with no control to open it. The
   button also stays hidden when the text is short enough not to need it, which
   is what happens on a tall phone or once the user has opened it on desktop
   width after a rotate. */
document.querySelectorAll('[data-fg-readmore]').forEach((button) => {
  const target = document.getElementById(button.getAttribute('aria-controls') || '');
  const label = button.querySelector('[data-fg-readmore-label]');
  if (!target || !label) return;

  const phone = window.matchMedia('(max-width: 900px)');
  const readMore = label.textContent || 'Read more';
  const readLess = 'Read less';
  let open = false;

  const apply = () => {
    if (!phone.matches) {
      target.classList.remove('is-clamped');
      button.hidden = true;
      return;
    }
    if (open) {
      target.classList.remove('is-clamped');
      button.hidden = false;
      return;
    }
    target.classList.add('is-clamped');
    // Measured with the clamp on, which is the only state where it overflows.
    const overflows = target.scrollHeight - target.clientHeight > 4;
    if (!overflows) target.classList.remove('is-clamped');
    button.hidden = !overflows;
  };

  button.addEventListener('click', () => {
    open = !open;
    label.textContent = open ? readLess : readMore;
    button.setAttribute('aria-expanded', String(open));
    apply();
  });

  apply();
  window.addEventListener('resize', apply, { passive: true });
});

/* Legend's verdict stamp on the pet flap page. Pressing it cycles his opinion.
   
   The first verdict is rendered server-side and stays visible, so this is a pure
   enhancement: with JavaScript off the stamp still reads as a finished thought
   and only the cycling is lost. The copy lives in PHP and arrives on a data
   attribute, so his voice is edited where the rest of the page copy is rather
   than in the bundle.
   
   aria-live on the verdict is already in the markup, so a screen reader hears
   each new one without the button needing to announce anything itself. */
document.querySelectorAll('[data-fg-legend-approved]').forEach((block) => {
  const button = block.querySelector('.fg-legend-approved__stamp');
  const verdict = block.querySelector('[data-fg-legend-verdict]');
  if (!button || !verdict) return;

  let verdicts = [];
  try {
    verdicts = JSON.parse(block.dataset.fgLegendVerdicts || '[]');
  } catch (_error) {
    verdicts = [];
  }
  if (!Array.isArray(verdicts) || verdicts.length < 2) return;

  // Start from whichever one PHP already printed, so the first press moves on
  // rather than repeating what is on screen.
  let index = Math.max(0, verdicts.indexOf(verdict.textContent.trim()));

  // The hint ships hidden so it can never invite a press that does nothing.
  const hint = block.querySelector('[data-fg-legend-hint]');
  if (hint) hint.hidden = false;

  button.addEventListener('click', () => {
    index = (index + 1) % verdicts.length;
    verdict.textContent = verdicts[index];
    button.classList.add('is-pressed');
    window.setTimeout(() => button.classList.remove('is-pressed'), 160);
  });
});

/* ---- Flush against standard, on one handle ---------------------------------
   The range input is the whole interaction. It sits invisible and stretched
   across the stage, so a drag can start anywhere on the photograph rather than
   only on the grip, and everything else — keyboard, touch, the announced value,
   the focus ring — comes from the platform rather than from here.

   All this does is copy the input's value onto `--fg-wipe`, which the clip and
   the seam both read. Nothing is measured and nothing is listened for on the
   window, so there is no scroll or resize path to get wrong: the component is
   correct at any width because the value is a percentage.

   No reduced-motion branch, deliberately. This is not motion the page performs
   at someone; it moves only while a person is actively dragging it, and pinning
   it would remove the only thing the component does. */
document.querySelectorAll('[data-fg-wipe]').forEach((stage) => {
  const range = stage.querySelector('[data-fg-wipe-range]');
  if (!range) return;

  const paint = () => stage.style.setProperty('--fg-wipe', `${range.value}%`);

  // `input` covers pointer, touch and keyboard on every browser this ships to.
  range.addEventListener('input', paint);
  paint();
});

/* Repair diagnostics — /window-and-door-repairs/
   ---------------------------------------------------------------------------
   Symptom in, part out, drawn. Choosing a symptom does three things: lights the
   matching group on the schematic, swaps the part panel, and swaps the caption
   under the drawing.

   The part copy lives in ONE place in the DOM and is swapped, rather than a
   hidden panel per symptom. Twelve symptoms across two products share nine
   parts, so per-symptom panels would have meant duplicated copy and the two
   drifting apart the first time somebody edited one.

   Everything the controller needs rides on the buttons as data attributes, and
   the part library is read once out of a JSON script block. Nothing is fetched.

   Progressive enhancement: the interactive shell is `hidden` in the markup and
   revealed here, and the plain symptom-to-part list is hidden here instead. So
   with no JavaScript you get real content rather than dead controls, and the
   symptom language is in the HTML either way. */
document.querySelectorAll('[data-fg-repair-diag]').forEach((diag) => {
  const shell = diag.querySelector('[data-fg-diag-shell]');
  const fallback = diag.querySelector('[data-fg-diag-fallback]');
  const store = diag.querySelector('[data-fg-diag-parts]');
  if (!shell || !store) return;

  let parts;
  try {
    parts = JSON.parse(store.textContent || '{}');
  } catch (e) {
    return; // Leave the fallback showing rather than a broken widget.
  }

  const panel = {
    image: diag.querySelector('[data-fg-diag-image]'),
    sub: diag.querySelector('[data-fg-diag-sub]'),
    name: diag.querySelector('[data-fg-diag-name]'),
    what: diag.querySelector('[data-fg-diag-what]'),
    fix: diag.querySelector('[data-fg-diag-fix]'),
    link: diag.querySelector('[data-fg-diag-link]'),
    caption: diag.querySelector('[data-fg-diag-caption]'),
  };
  const svgs = [...diag.querySelectorAll('[data-fg-diag-svg]')];
  const lists = [...diag.querySelectorAll('[data-fg-diag-list]')];
  const productButtons = [...diag.querySelectorAll('[data-fg-diag-product]')];

  shell.hidden = false;
  if (fallback) fallback.hidden = true;

  const showPart = (button) => {
    const key = button.dataset.part;
    const part = parts[key];
    if (!part) return;

    if (panel.image) {
      panel.image.src = part.image;
      panel.image.alt = part.alt || '';
      // Cut-outs are contained and given air; photographs cover their box.
      panel.image.closest('.fg-rp-diag__media').classList.toggle('is-cutout', !!part.cutout);
    }
    if (panel.sub) panel.sub.textContent = part.sub || '';
    if (panel.name) panel.name.textContent = part.name || '';
    if (panel.what) panel.what.textContent = part.what || '';
    if (panel.fix) panel.fix.textContent = part.fix || '';
    if (panel.caption) panel.caption.textContent = part.name || '';

    if (panel.link) {
      if (part.link) {
        panel.link.href = part.link;
        panel.link.textContent = part.link_label || '';
        panel.link.hidden = false;
      } else {
        panel.link.hidden = true;
      }
    }

    /* Light the group, or groups, on whichever schematic is showing.
       `data-svg` is space separated because some answers are genuinely two
       things: a window draught is the hinges OR the gasket, and a door that
       will not lock is the gearbox OR alignment. Lighting both is the honest
       drawing of that, and it is why this is a list rather than one id. */
    const targets = (button.dataset.svg || '').split(/\s+/).filter(Boolean);
    svgs.forEach((svg) => {
      const active = !svg.hasAttribute('hidden');
      svg.classList.toggle('is-focused', active);
      svg.querySelectorAll('[data-part]').forEach((g) => {
        g.classList.toggle('is-active', active && targets.includes(g.dataset.part));
      });
    });
  };

  const selectSymptom = (button) => {
    const list = button.closest('[data-fg-diag-list]');
    list.querySelectorAll('[data-fg-diag-symptom]').forEach((other) => {
      other.setAttribute('aria-pressed', other === button ? 'true' : 'false');
    });
    showPart(button);
  };

  diag.querySelectorAll('[data-fg-diag-symptom]').forEach((button) => {
    button.addEventListener('click', () => selectSymptom(button));
  });

  const selectProduct = (key) => {
    productButtons.forEach((b) => b.setAttribute('aria-pressed', b.dataset.fgDiagProduct === key ? 'true' : 'false'));
    lists.forEach((l) => { l.hidden = l.dataset.fgDiagList !== key; });

    /* `setAttribute`, not `.hidden`. The `hidden` IDL property is defined on
       HTMLElement and an <svg> is an SVGElement, which does not inherit it —
       so `svg.hidden = false` quietly sets a JS expando, the markup attribute
       never moves, and switching product changed the symptom list while the
       drawing stayed on the window. The lists above are real HTML elements and
       the property is fine there. */
    svgs.forEach((s) => {
      if (s.dataset.fgDiagSvg === key) {
        s.removeAttribute('hidden');
      } else {
        s.setAttribute('hidden', '');
      }
    });

    // Re-assert the visible list's current selection so the drawing and the
    // panel match the product you just switched to.
    const list = lists.find((l) => !l.hidden);
    if (!list) return;
    const current = list.querySelector('[aria-pressed="true"]') || list.querySelector('[data-fg-diag-symptom]');
    if (current) selectSymptom(current);
  };

  productButtons.forEach((b) => {
    b.addEventListener('click', () => selectProduct(b.dataset.fgDiagProduct));
  });

  selectProduct('window');
});

/* ------------------------------------------------------------------ *
 * Composite door style range — one collection at a time.
 *
 * The markup ships every collection visible with its own heading, so a visitor
 * with no JavaScript gets all 142 doors as six labelled grids and every link
 * still works. This collapses that to a switcher.
 *
 * `hidden` is used rather than a class because the stylesheet carries explicit
 * `[hidden] { display: none !important }` guards for both the switcher and the
 * panels. Setting `el.hidden = true` on something the stylesheet gives a
 * `display` is inert without them — the fault that made the case-study Show
 * more button do nothing and shipped both repairs drawings at once.
 * ------------------------------------------------------------------ */
document.querySelectorAll('.fg-cds').forEach((root) => {
  const switcher = root.querySelector('[data-fg-cds-switcher]');
  const panels = Array.from(root.querySelectorAll('[data-fg-cds-panel]'));
  if (!switcher || panels.length < 2) return;

  const tabs = Array.from(switcher.querySelectorAll('[role="tab"]'));
  if (tabs.length !== panels.length) return;

  /* NARROWING, NOT BROWSING. A hundred and forty two doors is a catalogue and a
     catalogue you cannot filter is a wall. The traits come off the markup, which
     PHP wrote from the same measured geometry the quiz scores on, so there is
     one source for both. */
  const filterBar = root.querySelector('[data-fg-cds-filters]');
  const FIRST_LOOK = 20;
  const expanded = new Set();

  /* The state is built from whatever chips the markup ships, so adding a
     filter back is a block in `$fg_cds_filters` and nothing here. Shape and
     Face were cut on the owner's instruction; glass stayed because it is the
     one somebody arrives with a view on, and the one the quiz treats as a
     requirement rather than a taste. */
  const state = {};
  if (filterBar) {
    filterBar.querySelectorAll('[data-fg-cds-filter]').forEach((chip) => {
      state[chip.dataset.fgCdsFilter] = '';
    });
  }

  const matches = (item) =>
    Object.keys(state).every((key) => state[key] === '' || item.dataset[key] === state[key]);

  const paint = (panel) => {
    const items = Array.from(panel.querySelectorAll('.fg-cds-door'));
    const index = panel.dataset.fgCdsPanel;
    const open = expanded.has(index);
    let shown = 0;
    let hits = 0;

    items.forEach((item) => {
      const hit = matches(item);
      if (hit) hits += 1;
      // The cap applies to what survives the filter, not to the raw list, so
      // narrowing to nine doors never hides three of them behind a button.
      const visible = hit && (open || shown < FIRST_LOOK);
      if (visible) shown += 1;
      item.hidden = !visible;
    });

    const result = panel.querySelector('[data-fg-cds-result]');
    const count = panel.querySelector('[data-fg-cds-count]');
    const more = panel.querySelector('[data-fg-cds-more]');
    if (!result || !count || !more) return;

    const filtered = Object.values(state).some((v) => v !== '');
    result.hidden = false;

    if (hits === 0) {
      count.textContent = 'No doors match that combination. Clear a filter to see more.';
      more.hidden = true;
      return;
    }

    count.textContent = filtered
      ? `${hits} of ${items.length} doors match`
      : `${items.length} doors`;

    if (hits > shown) {
      more.hidden = false;
      more.textContent = `Show all ${hits}`;
    } else if (open && hits > FIRST_LOOK) {
      more.hidden = false;
      more.textContent = 'Show fewer';
    } else {
      more.hidden = true;
    }
  };

  const paintAll = () => panels.forEach(paint);

  const show = (index, { focus = false } = {}) => {
    tabs.forEach((tab, i) => {
      const on = i === index;
      tab.setAttribute('aria-selected', on ? 'true' : 'false');
      tab.tabIndex = on ? 0 : -1;
      if (on && focus) tab.focus();
    });
    panels.forEach((panel, i) => {
      if (i === index) {
        panel.removeAttribute('hidden');
      } else {
        panel.setAttribute('hidden', '');
      }
    });
  };

  tabs.forEach((tab, i) => {
    tab.addEventListener('click', () => show(i));
    tab.addEventListener('keydown', (event) => {
      /* Arrow keys move between tabs, which is what a tablist is expected to do
         and is the only way a keyboard user reaches collection six without
         tabbing through 19 door links first. */
      const step = event.key === 'ArrowRight' ? 1 : event.key === 'ArrowLeft' ? -1 : 0;
      if (step === 0) return;
      event.preventDefault();
      show((i + step + tabs.length) % tabs.length, { focus: true });
    });
  });

  if (filterBar) {
    filterBar.querySelectorAll('[data-fg-cds-filter]').forEach((chip) => {
      chip.addEventListener('click', () => {
        const key = chip.dataset.fgCdsFilter;
        state[key] = chip.dataset.value;
        filterBar
          .querySelectorAll(`[data-fg-cds-filter="${key}"]`)
          .forEach((sibling) => sibling.setAttribute('aria-pressed', sibling === chip ? 'true' : 'false'));
        // A new filter is a new first look, so an expanded panel folds back.
        expanded.clear();
        paintAll();
      });
    });
    filterBar.removeAttribute('hidden');
  }

  panels.forEach((panel) => {
    const more = panel.querySelector('[data-fg-cds-more]');
    if (!more) return;
    more.addEventListener('click', () => {
      const index = panel.dataset.fgCdsPanel;
      if (expanded.has(index)) expanded.delete(index); else expanded.add(index);
      paint(panel);
    });
  });

  /* Enhance last, so a throw above leaves the honest six-grid version intact. */
  switcher.removeAttribute('hidden');
  root.classList.add('is-enhanced');
  paintAll();
  show(0);
});

/* ------------------------------------------------------------------ *
 * Composite door quiz — one question at a time, then a reveal.
 *
 * Answers advance on click rather than waiting for a submit. The format only
 * works with momentum; a submit button under four questions is a form, not a
 * quiz, and nobody shares a form.
 *
 * Scoring runs on traits computed from real cassette geometry (see
 * `inc/composite-door-data.php`), and ties break on data order and never
 * randomly — the result is shared as `?door=<key>`, and a link that showed the
 * recipient a different door than the sender saw would be worse than no sharing.
 * ------------------------------------------------------------------ */
document.querySelectorAll('[data-fg-door-quiz]').forEach((root) => {
  let doors;
  try { doors = JSON.parse(root.dataset.fgQuizDoors || '[]'); } catch (e) { return; }
  if (!doors.length) return;

  const panel = root.querySelector('[data-fg-quiz-panel]');
  const steps = Array.from(root.querySelectorAll('[data-fg-quiz-step]'));
  const result = root.querySelector('[data-fg-quiz-result]');
  const frame = root.querySelector('[data-fg-quiz-frame]');
  const pips = Array.from(root.querySelectorAll('[data-fg-quiz-pip]'));
  const count = root.querySelector('[data-fg-quiz-count]');
  if (!panel || !result || !frame || !steps.length) return;

  const artBase = root.dataset.fgQuizArt || '';
  const artVer = root.dataset.fgQuizVer || '';
  const quoteTpl = root.dataset.fgQuizQuote || '';
  /* Colour rides on the URL rather than the scoring. `colour=` takes WindowCAD's
     PALETTE key — passing the colour collection's own entry key does nothing at
     all and the door renders white, which is what the first attempt did. */
  const quoteFor = (key, colour) => {
    const url = quoteTpl.replace('__KEY__', encodeURIComponent(key));
    return (colour == null || colour === '') ? url : url + '&colour=' + encodeURIComponent(colour);
  };

  const prefs = {};
  let at = 0;

  /* An exact match scores most, a near one still scores. All-or-nothing on four
     questions leaves most of the range tied on zero, and the answer then falls
     to whatever happens to sit first in the data. */
  const score = (d) => {
    let s = 0;
    if (prefs.m != null) s += d.m === prefs.m ? 3 : 0;
    if (prefs.d != null) s += Math.max(0, 3 - Math.abs(d.d - prefs.d) * 2);
    if (prefs.v != null) s += d.v === prefs.v ? 2 : 0;
    return s;   /* glass is handled by the filter in `finish`, not scored here */
  };

  const reasonFor = (d) => {
    const bits = [];
    if (d.g === 3) bits.push('it puts about as much glass in the door as the style allows');
    else if (d.g === 0) bits.push('it is solid, with no glazing in it at all');
    else if (d.g === 1) bits.push('it lets a little light through without opening the hall up');
    else bits.push('it gives a decent amount of light without turning the door into a window');
    if (d.v) bits.push('and there is a curve in it rather than all straight lines');
    else if (d.d === 2) bits.push('and there is real detail in the face');
    else if (d.d === 0) bits.push('and the face is kept plain');
    return 'Because ' + bits.join(', ') + '.';
  };

  const paint = () => {
    steps.forEach((s, i) => {
      if (i === at) s.removeAttribute('hidden'); else s.setAttribute('hidden', '');
      const back = s.querySelector('[data-fg-quiz-back]');
      if (back) { if (i > 0) back.removeAttribute('hidden'); else back.setAttribute('hidden', ''); }
    });
    pips.forEach((p, i) => p.classList.toggle('is-done', i <= at));
    /* Big numerals rather than a sentence: the counter is set at display
       size in the quiz band, and "Question 1 of 5" at that size is a
       paragraph pretending to be a number. */
    if (count) count.textContent = String(Math.min(at + 1, steps.length)).padStart(2, '0') + ' / ' + String(steps.length).padStart(2, '0');
  };

  const reveal = (door, explain) => {
    root.querySelector('[data-fg-quiz-name]').textContent = door.n;
    root.querySelector('[data-fg-quiz-collection]').textContent = door.c + ' collection';
    const img = root.querySelector('[data-fg-quiz-art-img]');
    img.src = artBase + encodeURIComponent(door.k) + '.svg' + (artVer ? '?v=' + artVer : '');
    img.alt = door.n + ', ' + door.c + ' collection';
    root.querySelector('[data-fg-quiz-why]').textContent = explain ? reasonFor(door) : '';
    root.querySelector('[data-fg-quiz-open]').href = quoteFor(door.k, prefs.c);
    const colourLine = root.querySelector('[data-fg-quiz-colour]');
    if (colourLine) {
      const name = colourNames[String(prefs.c)];
      if (name) { colourLine.textContent = 'Shown in ' + name; colourLine.removeAttribute('hidden'); }
      else colourLine.setAttribute('hidden', '');
    }
    const poa = root.querySelector('[data-fg-quiz-poa]');
    if (poa) { if (door.p) poa.removeAttribute('hidden'); else poa.setAttribute('hidden', ''); }

    frame.innerHTML = '';
    const iframe = document.createElement('iframe');
    iframe.src = quoteFor(door.k, prefs.c);
    iframe.title = 'Design and price the ' + door.n + ' online';
    iframe.loading = 'lazy';
    frame.appendChild(iframe);

    steps.forEach((s) => s.setAttribute('hidden', ''));
    result.removeAttribute('hidden');
    root.classList.add('is-revealed');
    pips.forEach((p) => p.classList.add('is-done'));
    if (count) count.textContent = 'Your door';

    try {
      /* Built from the path rather than `location.href`. A URL carrying
         basic-auth credentials — which the test site's do — makes replaceState
         throw, and losing the share link over that is not worth it. */
      const q = '?door=' + encodeURIComponent(door.k) + (prefs.c != null ? '&colour=' + encodeURIComponent(prefs.c) : '');
      window.history.replaceState({}, '', window.location.pathname + q);
    } catch (e) { /* a URL we cannot rewrite is not a reason to lose the result */ }
  };

  /* GLASS IS A FILTER, NOT A SCORE, AND THAT IS THE FIX FOR THE OBVIOUS BUG.
     The first version scored it alongside everything else, so answering "keep
     it solid" could be outvoted by the house, the detail and the curve, and the
     quiz cheerfully returned a door with windows in it. Somebody who says no
     glass means no glass; the other three answers are taste, and taste does not
     get to overrule a requirement. The fallback only fires if a level is empty,
     which it never is — the sweep in the generator asserts all 72 answer
     combinations come back at the requested glass level. */
  const finish = () => {
    let pool = prefs.g == null ? doors : doors.filter((d) => d.g === prefs.g);
    if (!pool.length) pool = doors;
    let best = null, top = -1;
    pool.forEach((d) => { const s = score(d); if (s > top) { top = s; best = d; } });
    if (best) reveal(best, true);
  };

  /* The name for the chip they picked, for the reveal line. */
  const colourNames = {};
  root.querySelectorAll('[data-fg-quiz-q="c"] [data-fg-quiz-answer]').forEach((b) => {
    const strong = b.querySelector('strong');
    if (strong) colourNames[b.dataset.fgQuizAnswer] = strong.textContent.trim();
  });

  steps.forEach((step, index) => {
    const id = step.dataset.fgQuizQ;
    step.querySelectorAll('[data-fg-quiz-answer]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const raw = btn.dataset.fgQuizAnswer;
        prefs[id] = raw === '' ? null : Number(raw);
        if (index + 1 < steps.length) { at = index + 1; paint(); }
        else finish();
      });
    });
    const back = step.querySelector('[data-fg-quiz-back]');
    if (back) back.addEventListener('click', () => { at = Math.max(0, index - 1); paint(); });
  });

  const resetBtn = root.querySelector('[data-fg-quiz-reset]');
  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      ['m', 'g', 'd', 'v', 'c'].forEach((k) => { delete prefs[k]; });
      at = 0;
      result.setAttribute('hidden', '');
      root.classList.remove('is-revealed');
      frame.innerHTML = '';
      pips.forEach((p) => p.classList.remove('is-done'));
      paint();
      try { window.history.replaceState({}, '', window.location.pathname); } catch (e) { /* nothing to undo */ }
    });
  }

  const shareBtn = root.querySelector('[data-fg-quiz-share]');
  if (shareBtn) {
    const label = shareBtn.textContent;
    shareBtn.addEventListener('click', async () => {
      const name = (root.querySelector('[data-fg-quiz-name]') || {}).textContent || 'this door';
      const url = window.location.href;
      try {
        if (navigator.share) { await navigator.share({ title: 'I am a ' + name, url }); return; }
        await navigator.clipboard.writeText(url);
        shareBtn.textContent = 'Link copied';
        window.setTimeout(() => { shareBtn.textContent = label; }, 2400);
      } catch (e) {
        /* A cancelled share sheet or a refused clipboard is not worth shouting
           about; the link is already in the address bar. */
        shareBtn.textContent = 'It is in the address bar';
        window.setTimeout(() => { shareBtn.textContent = label; }, 2800);
      }
    });
  }

  panel.hidden = false;
  paint();

  try {
    const params = new URL(window.location.href).searchParams;
    const shared = params.get('door');
    if (shared) {
      const door = doors.find((d) => d.k === shared);
      const col = params.get('colour');
      if (col) prefs.c = col;
      if (door) reveal(door, false);
    }
  } catch (e) { /* no shared result to restore */ }
});
