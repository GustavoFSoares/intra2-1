import Signature from "./Signature";
export default class EletronicDocumentAmendment {
    constructor(eletronicDocumentAmendment = {  }) {
        this.id = eletronicDocumentAmendment.id
        this.title = eletronicDocumentAmendment.title
        this.text = eletronicDocumentAmendment.text
        this.signatureList = eletronicDocumentAmendment.signatureList ? eletronicDocumentAmendment.signatureList : [ new Signature() ]
        this.signatureUsers = eletronicDocumentAmendment.signature ? eletronicDocumentAmendment.signature : []
        this.user = eletronicDocumentAmendment.user ? eletronicDocumentAmendment.user : window.$session.get('user')
    }
}