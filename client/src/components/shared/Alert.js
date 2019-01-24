const bootbox = require('bootbox');

export default {
    YesNo: (title = "YesNo", message = "Message") => {
        return new Promise((resolve) => {
            bootbox.confirm({
                title: title,
                message: message,
                buttons: {
                    cancel: {
                        label: 'Não',
                        className: 'btn-danger'
                    },
                    confirm: {
                        label: 'Sim',
                        className: 'btn-success'
                    },

                },
                callback: result => {
                    resolve(result)
                }
            })
        })
    },
    Confirm: (message = "Message") => {
        return new Promise((resolve) => {
            bootbox.confirm(
                message,
                result => { resolve(result) }
            )
        })
    },
    TextArea: (title = "TextArea") => {
        return new Promise((resolve) => {
            bootbox.prompt({
                title: title,
                inputType: 'textarea',
                callback: result => {
                    resolve(result)
                }
            });
        })
    }
}