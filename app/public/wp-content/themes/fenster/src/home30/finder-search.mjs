/**
 * Literal, ranked catalogue search with a small spelling-tolerance fallback.
 * No network calls. All terms come from the site's curated product catalogue.
 */
export function normalise(value) {
    return value.toLowerCase().normalize('NFKD').replace(/[\u0300-\u036f]/g, '')
        .replace(/bi[ -]+fold/g, 'bifold').replace(/roof[ -]+light/g, 'rooflight')
        .replace(/tilt[ -]+and[ -]+turn/g, 'tilt turn')
        .replace(/aluminum/g, 'aluminium').replace(/sashes/g, 'sash')
        .replace(/[^a-z0-9]+/g, ' ').trim().split(/\s+/)
        .map(function (word) {
            if (word === 'skylight' || word === 'skylights') return 'rooflight';
            return word.length > 3 && !word.endsWith('ss') ? word.replace(/s$/, '') : word;
        }).join(' ');
}

const filler = new Set(['i', 'im', 'want', 'need', 'looking', 'for', 'a', 'an', 'the', 'some', 'my', 'our', 'new', 'to', 'with', 'please', 'of', 'and']);
export function queryTokens(query) {
    return normalise(query).split(' ').filter(function (word) { return word && !filler.has(word); });
}

// A missing/extra letter, one replacement or adjacent transposition.
function closeWord(a, b) {
    if (a.length < 4 || b.length < 4 || Math.abs(a.length - b.length) > 1) return false;
    if (a.length === b.length) {
        const differences = [];
        for (let i = 0; i < a.length; i++) if (a[i] !== b[i]) differences.push(i);
        return differences.length <= 1 || (differences.length === 2 &&
            differences[1] === differences[0] + 1 &&
            a[differences[0]] === b[differences[1]] && a[differences[1]] === b[differences[0]]);
    }
    const shorter = a.length < b.length ? a : b;
    const longer = a.length < b.length ? b : a;
    let i = 0;
    while (i < shorter.length && shorter[i] === longer[i]) i++;
    return shorter.slice(i) === longer.slice(i + 1);
}

export function searchCatalogue(catalogue, query) {
    const tokens = queryTokens(query);
    if (!tokens.length) return {items: [], approximate: false};
    function ranked(approximate) {
        return catalogue.map(function (item, index) {
            const title = normalise(item.label);
            const words = normalise(item.terms).split(' ');
            let score = title.includes(normalise(query)) ? 30 : 0;
            for (const token of tokens) {
                if (words.some(function (word) { return word.includes(token); })) {
                    score += title.split(' ').includes(token) ? 10 : title.includes(token) ? 6 : 2;
                } else if (approximate && words.some(function (word) { return closeWord(token, word); })) {
                    score += 1;
                } else {
                    return null;
                }
            }
            return {item, score, index};
        }).filter(Boolean).sort(function (a, b) { return b.score - a.score || a.index - b.index; })
            .map(function (result) { return result.item; });
    }
    const exact = ranked(false);
    return exact.length ? {items: exact, approximate: false} : {items: ranked(true), approximate: true};
}
