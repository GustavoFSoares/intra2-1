import service from "@/services/room-training"

const getters = {
    getRoomsTraining: () => service.getRoomsTraining(),
    getRoomTrainingById: (id) => service.getRoomsTraining({ 'id':id }),
}

const model = {
    doInsert: (roomTraining) => service.insert(roomTraining),
    doUpdate: (id, roomTraining) => service.update(id, roomTraining),
    isEdit(id) {
        if (id) {
            return true
        }
        return false
    },
}

export default model
export const getter = getters