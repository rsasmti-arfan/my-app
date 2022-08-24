import { Router } from 'express'
import { body, query } from 'express-validator'
import {
    createSession,
    deleteSession,
    formatPhone,
    getSession,
    isExists,
    isSessionExists,
    sendMessage,
} from './Connection.js'
import { requestValidator, sessionValidator } from '../helpers/middleware.js'
import response from '../helpers/response.js'

const router = Router()

/**
 * Sessions router
 */
router
    // find
    .get('/sessions/find/:id', sessionValidator, async (req, res) => {
        return response(res, 200, true, 'Session ditemukan.')
    })
    // status
    .get('/sessions/status/:id', sessionValidator, async (req, res) => {
        const states = ['connecting', 'connected', 'disconnecting', 'disconnected']

        const session = getSession(res.locals.sessionId)
        let state = states[session.ws.readyState]

        state =
            state === 'connected' &&
            typeof (session.isLegacy ? session.state.legacy.user : session.user) !== 'undefined'
                ? 'authenticated'
                : state

        response(res, 200, true, '', { status: state })
    })
    // add
    .post('/sessions/add', body('id').notEmpty(), requestValidator, async (req, res) => {
        const { id } = req.body

        if (isSessionExists(id)) {
            return response(res, 409, false, 'Session sudah ada, silakan gunakan id lain.')
        }

        createSession(id, false, res)
    })
    // delete
    .delete('/sessions/delete/:id', sessionValidator, async (req, res) => {
        const { id } = req.params
        const session = getSession(id)

        try {
            await session.logout()
        } catch {
        } finally {
            deleteSession(id, session.isLegacy)
        }

        response(res, 200, true, 'Session telah berhasil dihapus.')
    })

/**
 * Chats router
 */
router
    // send
    .post(
        '/chats/send',
        query('id').notEmpty(),
        body('receiver').notEmpty(),
        body('message').notEmpty(),
        requestValidator,
        sessionValidator,
        async (req, res) => {
            const session = getSession(res.locals.sessionId)
            const receiver = formatPhone(req.body.receiver)
            const { message } = req.body

            try {
                const exists = await isExists(session, receiver)

                if (!exists) {
                    return response(res, 400, false, 'Nomor penerima tidak ada.')
                }

                await sendMessage(session, receiver, { text: message })

                response(res, 200, true, 'Pesan telah berhasil terkirim.')
            } catch {
                response(res, 500, false, 'Gagal mengirim pesan.')
            }
        }
    )
    // send-bulk
    .post('/chats/send-bulk', query('id').notEmpty(), requestValidator, sessionValidator, async (req, res) => {
        const session = getSession(res.locals.sessionId)
        const errors = []

        for (const [key, data] of req.body.entries()) {
            if (!data.receiver || !data.message) {
                errors.push(key)

                continue
            }

            data.receiver = formatPhone(data.receiver)

            try {
                const exists = await isExists(session, data.receiver)

                if (!exists) {
                    errors.push(key)

                    continue
                }

                await sendMessage(session, data.receiver, { text: data.message })
            } catch {
                errors.push(key)
            }
        }

        if (errors.length === 0) {
            return response(res, 200, true, 'Semua pesan telah berhasil terkirim.')
        }

        const isAllFailed = errors.length === req.body.length

        response(
            res,
            isAllFailed ? 500 : 200,
            !isAllFailed,
            isAllFailed ? 'Gagal mengirim semua pesan.' : 'Beberapa pesan telah berhasil dikirim.',
            { errors }
        )
    })
    // send bulk pada localhost
    .post('/chats/send-bulk2', query('id').notEmpty(), requestValidator, sessionValidator, async (req, res) => {
        const session = getSession(res.locals.sessionId)
        let errors = []

        let dataEntries = req.body

        dataEntries.map(async (data, key) => {
            if (!data.receiver || !data.message) {
                errors.push(key)
            }

            data.receiver = formatPhone(data.receiver)

            try {
                const exists = await isExists(session, data.receiver)

                if (!exists) {
                    errors.push(key)
                }

                await sendMessage(session, data.receiver, { text: data.message })
            } catch (error) {
                console.log(error)
            }
        })

        if (errors.length === 0) {
            return response(res, 200, true, 'Semua pesan telah berhasil terkirim.')
        }

        const isAllFailed = errors.length === req.body.length

        response(
            res,
            isAllFailed ? 500 : 200,
            !isAllFailed,
            isAllFailed ? 'Gagal mengirim semua pesan.' : 'Beberapa pesan telah berhasil dikirim.',
            { errors }
        )
    })

export default router
