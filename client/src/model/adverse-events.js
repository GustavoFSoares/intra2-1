import services, { getters } from "@/services/adverse-events";
import { EmailDefault } from "../entity";

const getSectorsBy = (id) => services.getSectorsBy(id)
const getEnterprises = () => services.getEnterprises()
const getEvents = () => services.getEvents()

const sendData = (report) => {
    report.sender = verifyEmail(report.reporter)
    
    return services.sendData(report)
}

const verifyEmail = (reporter) => {
    let sender = new EmailDefault()
    
    if(reporter.anonymous) {
        return sender
    } else {
        sender.name = reporter.name
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