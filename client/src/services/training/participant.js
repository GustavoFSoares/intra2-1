import http from '../client'

export default {
    getParticipantsTraining: (trainingId) => {
        return http.get(`/training-participant/${trainingId}`).then(res => res.data)
    },
    getTrainingsByParticipant: (participantId) => {
        return http.get(`/training-participant/user/${participantId}`).then(res => res.data)
    },

    addParticipants: (trainingId, data) => {
        return http.put(`/training-participant/${trainingId}`, data).then(res => res.data)
    },
    addParticipant: (trainingId, data) => {
        return http.put(`/training-participant/add-user/${trainingId}`, data).then(res => res.data)
    },

    removeParticipant: (userId, trainingId) => {
        return http.put(`/training-participant/`, {userId, trainingId}).then(res => res.data)
    },

}