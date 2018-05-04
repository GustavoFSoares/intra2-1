import services, { getters } from "@/services/adverse-events";
import Email from "@/model/email_template/adverse-events-template";
import { EmailDefault } from "../entity";

const getSectorsBy = (id) => services.getSectorsBy(id)
const getEnterprises = () => services.getEnterprises()
const getEvents = () => services.getEvents()

const sendData = (report) => {
    report.sender = verifyEmail(report.sender)

    services.saveData(report)
    
    report = Email(report)
    
    return services.sendMail(report)
}

const verifyEmail = (sender) => {
    if(sender.anonymous) {
        return EmailDefault
    } else {
        return sender
    }
}

const getEventById = (id) => getters.getEventById(id)
const getEnterpriseById = (id) => getters.getEnterpriseById(id)
const getSectorById = (id) => getters.getSectorById(id)

export default {
    sendData,
    getEvents,
    getEnterprises,
    getSectorsBy,
}

export const descriptions = {
    getEventById,
    getSectorById,
    getEnterpriseById,
}