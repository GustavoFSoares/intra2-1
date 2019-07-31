export default class EletronicDocument {
    constructor(eletronicDocument = { 
        user: window.$session.get('user'), draft: true, signatureList: [ ], groupList: [ ], type: { id:1, name: "Memorando"},
     }) {
        this.id = eletronicDocument.id ? eletronicDocument.id : this.getId()
        this.subject = eletronicDocument.subject
        this.user = eletronicDocument.user
        this.nextSignature = eletronicDocument.nextSignature
        this.type = eletronicDocument.type
        this.status = eletronicDocument.status
        this.archived = eletronicDocument.archived ? true : false
        this.canceled = eletronicDocument.canceled ? true : false
        this.finished = eletronicDocument.finished ? true : false
        this.signed = eletronicDocument.signed ? true : false
        this.signatureList = eletronicDocument.signatureList ? eletronicDocument.signatureList : []
        this.amendmentList = eletronicDocument.amendmentList ? eletronicDocument.amendmentList : []
        this.groupList = eletronicDocument.groupList ? eletronicDocument.groupList : []
        this.draft = eletronicDocument.draft ? true : false
        this.content = eletronicDocument.content
    }

    getId() {
        let d = new Date()
        return `${d.getFullYear()}${(d.getMonth() + 1)}${d.getDate()}${d.getMinutes()}.${d.getSeconds()}${d.getMilliseconds()}`
    }

    isLoaded() {
        return this.status ? true : false
    }

    isBlocked() {
        if(this.isLoaded()) {
            return ['revoked', 'canceled', 'waiting-correction'].includes(this.status.id) || this.canceled
        }
        return false
    }

    isInProssessing() {
        if(this.isLoaded()) {
            return ['sending', 'waiting-correction', 'waiting-signature'].includes(this.status.id)
        }
        return false
    }
}