import { isSessionExists } from '../src/Connection.js'
import { validationResult } from 'express-validator'
import response from './response.js'

const sessionValidator = (req, res, next) => {
    const sessionId = req.query.id ?? req.params.id

    if (!isSessionExists(sessionId)) {
        return response(res, 404, false, 'Session tidak ditemukan.')
    }

    res.locals.sessionId = sessionId
    next()
}

const requestValidator = (req, res, next) => {
    const errors = validationResult(req)

    if (!errors.isEmpty()) {
        return response(res, 400, false, 'Silahkan isi semua input yang diperlukan.')
    }

    next()
}

export { sessionValidator, requestValidator }
