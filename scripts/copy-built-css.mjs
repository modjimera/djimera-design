import { copyFileSync, existsSync, mkdirSync } from 'node:fs';
import { dirname, resolve } from 'node:path';

const source = resolve('public/build/assets/app.css');
const target = resolve('public/css/app.css');

if (!existsSync(source)) {
    throw new Error(`Built CSS not found: ${source}`);
}

mkdirSync(dirname(target), { recursive: true });
copyFileSync(source, target);

console.log(`Copied ${source} to ${target}`);
