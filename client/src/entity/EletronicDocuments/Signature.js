import User from "@/entity/User";
export default class EletronicDocumentSignature {
    constructor(eletronicDocumentSignature = {  }) {
        this.id = eletronicDocumentSignature.id
        this.user = eletronicDocumentSignature.user ? eletronicDocumentSignature.user : new User()
        this.signed = eletronicDocumentSignature.signed ? true : false
        this.agree = eletronicDocumentSignature.agree
        this.bc = eletronicDocumentSignature.bc ? true : false
    }
}