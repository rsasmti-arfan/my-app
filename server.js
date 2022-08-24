import 'dotenv/config'
import http from 'http'
import app from './server/app.js'
import { init, cleanup } from './server/src/Connection.js'

const port = parseInt(process.env.NODE_PORT ?? 9000)

http.createServer(app).listen(port, () => {
    init()
    console.log(`Server running at *:${port}`)
})

export default app
