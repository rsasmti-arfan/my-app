import 'dotenv/config'
import express from 'express'
import nodeCleanup from 'node-cleanup'
import { cleanup } from './src/Connection.js'
import cors from 'cors'
import Api from './src/Api.js'

import response from './helpers/response.js'

const app = express()

app.use(cors())
app.use(express.urlencoded({ extended: true }))
app.use(express.json())

/** api routes */
app.use('/', Api)

app.get('/ping', (req, res) => {
    return response(res, 200, 'Node server berjalan.', [])
})

nodeCleanup(cleanup)

export default app
