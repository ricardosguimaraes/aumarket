"use strict"

function tdfSetFieldTitle(fieldKey) {
    const field = window.tdfElementor.fields.find((field) => {
        return field.key === fieldKey
    })

    if (typeof field === 'undefined') {
        return fieldKey
    }

    return field.name
}