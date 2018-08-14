import service from "@/services/training/participant"

const getters = {
    getParticipantsTraining: (trainingId) => service.getParticipantsTraining(trainingId),
    getTrainingsByParticipant: (participantId) => service.getTrainingsByParticipant(participantId)

}

const model = {
    addParticipants: (trainingId, data) => service.addParticipants(trainingId, data),
    addParticipant: (trainingId, participant) => service.addParticipant(trainingId, participant),

    removeParticipant: (userId, trainingId) => service.removeParticipant(userId, trainingId),
}

export default model
export const getter = getters