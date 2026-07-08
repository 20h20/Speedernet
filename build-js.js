/**
 * Build JS — copie les sources vers library/js/
 * Usage : node build-js.js
 */

const fs   = require('fs');
const path = require('path');

const base = __dirname;

function copy(src, dst) {
	fs.mkdirSync(path.dirname(dst), { recursive: true });
	fs.copyFileSync(src, dst);
	console.log('  ✓', path.relative(base, dst));
}

// ── Libs ────────────────────────────────────────────────────────────
console.log('\nLibs →');
const libsSrc = path.join(base, 'src/js/libs');
const libsDst = path.join(base, 'library/js/libs');

fs.readdirSync(libsSrc)
	.filter(f => f.endsWith('.js'))
	.forEach(f => copy(path.join(libsSrc, f), path.join(libsDst, f)));

// ── Blocks ───────────────────────────────────────────────────────────
console.log('\nBlocks →');
const blocksDir = path.join(base, 'templates/blocks');
const blocksDst = path.join(base, 'library/js/blocks');

fs.readdirSync(blocksDir).forEach(name => {
	const src = path.join(blocksDir, name, 'script.js');
	if (fs.existsSync(src)) copy(src, path.join(blocksDst, name + '.js'));
});

// ── Parts ────────────────────────────────────────────────────────────
console.log('\nParts →');
const partsDir = path.join(base, 'templates/parts');
const partsDst = path.join(base, 'library/js/parts');

fs.readdirSync(partsDir).forEach(name => {
	const src = path.join(partsDir, name, 'script.js');
	if (fs.existsSync(src)) copy(src, path.join(partsDst, name + '.js'));
});

console.log('\nDone.\n');
