import test from 'node:test';
import assert from 'node:assert/strict';
import {searchCatalogue} from './finder-search.mjs';

const catalogue = [
    {label: 'uPVC windows', terms: 'uPVC windows Side or top opening casements replacement double glazing'},
    {label: 'Front doors', terms: 'Front doors Composite doors in your choice of colour entrance distinction'},
    {label: 'Bifold doors', terms: 'Bifold doors Fold the panels back onto the garden folding aluminium aluminum'},
    {label: 'Aluminium entrance doors', terms: 'Aluminium entrance doors A single aluminium door front entrance'},
    {label: 'Roof lanterns', terms: 'Roof lanterns daylight flat roof extension skylight'},
    {label: 'Flat rooflights', terms: 'Flat rooflights Glazing that sits low on a flat roof skylight'},
    {label: 'Privacy glass', terms: 'Privacy glass Patterned glass for bathrooms and doors frosted'},
];

test('finds front doors across the catalogue, with the named product first', () => {
    const result = searchCatalogue(catalogue, 'front door');
    assert.deepEqual(result.items.map(item => item.label), ['Front doors', 'Aluminium entrance doors']);
    assert.equal(result.approximate, false);
});
test('accepts homeowner phrasing and common spelling variants', () => {
    assert.equal(searchCatalogue(catalogue, 'I need new windows please').items[0].label, 'uPVC windows');
    assert.equal(searchCatalogue(catalogue, 'aluminum bi-fold doors').items[0].label, 'Bifold doors');
    assert.deepEqual(searchCatalogue(catalogue, 'roof lights').items.map(item => item.label), ['Flat rooflights', 'Roof lanterns']);
});
test('uses spelling tolerance only when there are no literal matches', () => {
    const result = searchCatalogue(catalogue, 'biflod doors');
    assert.equal(result.approximate, true);
    assert.equal(result.items[0].label, 'Bifold doors');
    assert.equal(searchCatalogue(catalogue, 'glass').approximate, false);
});
test('unrelated terms and filler-only queries do not produce invented matches', () => {
    for (const query of ['mortgage', 'windows banana', 'I want a', '<script>alert(1)</script>']) {
        assert.deepEqual(searchCatalogue(catalogue, query).items, [], query);
    }
});
