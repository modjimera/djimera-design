import { copyFileSync, existsSync, mkdirSync, readFileSync } from 'node:fs';
import { dirname, resolve } from 'node:path';

const cssSource = resolve('public/build/assets/app.css');
const cssTarget = resolve('public/css/app.css');

if (!existsSync(cssSource)) {
    throw new Error(`Built CSS not found: ${cssSource}`);
}

mkdirSync(dirname(cssTarget), { recursive: true });
copyFileSync(cssSource, cssTarget);

const manifest = JSON.parse(readFileSync(resolve('public/build/manifest.json'), 'utf8'));
const jsFile = manifest['resources/js/app.js']?.file;

if (!jsFile) {
    throw new Error('Built JS entry not found in manifest');
}

const jsSource = resolve('public/build', jsFile);
const jsTarget = resolve('public/js/app.js');

if (!existsSync(jsSource)) {
    throw new Error(`Built JS not found: ${jsSource}`);
}

mkdirSync(dirname(jsTarget), { recursive: true });
copyFileSync(jsSource, jsTarget);

console.log(`Copied ${cssSource} to ${cssTarget}`);
console.log(`Copied ${jsSource} to ${jsTarget}`);
