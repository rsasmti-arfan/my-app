import { dirname } from 'path'
import { fileURLToPath } from 'url'

const __dirname = dirname(fileURLToPath(import.meta.url))
// const __dirname = new URL('./', import.meta.url).pathname

export default __dirname
