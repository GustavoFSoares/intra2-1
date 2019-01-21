export default class EletronicDocument {
    constructor(eletronicDocument = { 
        user: window.$session.get('user'), draft: true, userList: [ ], groupList: [ ]
     }) {
        this.id = eletronicDocument.id ? eletronicDocument.id : this.getId()
        this.subject = eletronicDocument.subject
        this.user = eletronicDocument.user
        this.type = eletronicDocument.type
        this.status = eletronicDocument.status
        this.signed = eletronicDocument.signed ? true : false
        this.userList = eletronicDocument.userList ? eletronicDocument.userList : []
        this.groupList = eletronicDocument.groupList ? eletronicDocument.groupList : []
        this.draft = eletronicDocument.draft ? true : false
        this.content = eletronicDocument.content
    }

    getId() {
        let d = new Date()
        return `${d.getFullYear()}${(d.getMonth() + 1)}${d.getDate()}${d.getMinutes()}.${d.getSeconds()}${d.getMilliseconds()}`
    }
}