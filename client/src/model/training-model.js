import service from "@/services/training"
import serviceUser from "@/services/user"

const getters = {
    getUserById: (id) => serviceUser.getUsers(id),
    getTrainings: () => service.getTrainings(),
    getTrainingsUnrealized: () => service.getTrainingsUnrealized(),
    getTrainingById: (id) => service.getTrainings({ 'id':id }),
    getTrainingsType: () => service.getTrainingsType(),
}

const model = {
    doInsert: (data) => service.doInsert(data),
    isEdit(id) {
        if(id) {
            return true
        }
        return false
    },
    isDone: (trainingId) => service.isDone(trainingId),
    doUpdate: (id, data) => service.doUpdate(id, data),
    doDelete: (id) => service.doDelete(id),
    indexOf: (users, user) => {
        let ok
        users.forEach((u, index) => {
            if (u.id == user.id) {
                ok = index
            }
        })
        return ok
    },
    mount(data, dateTraining) {
        let training = JSON.parse(JSON.stringify(data))
        training.beginTime = new Date(training.beginTime)
        training.endTime = new Date(training.endTime)


        if(typeof dateTraining == 'string') {
            let date = dateTraining.split('-')
            dateTraining = new Date(date[0], date[1] - 1, date[2])
        }
        
        let day = dateTraining.getDate();
        let month = dateTraining.getMonth();
        let year = dateTraining.getFullYear();
        
        training.beginTime.setDate(day)
        training.beginTime.setMonth(month)
        training.beginTime.setFullYear(year)
        
        training.endTime.setDate(day)
        training.endTime.setMonth(month)
        training.endTime.setFullYear(year)

        let name = ''
        if (training.name.name == "Outros") {
            name = training.anotherName
            delete training.anotherName;
        } else {
            name = training.name.name ? training.name.name : training.name
        }
        training.name = name
        
        training.beginTime = `${training.beginTime.getDate()}/${training.beginTime.getMonth() + 1}/${training.beginTime.getFullYear()} ${training.beginTime.getHours()}:${training.beginTime.getMinutes()}:${training.beginTime.getSeconds()}`
        training.endTime = `${training.endTime.getDate()}/${training.endTime.getMonth() + 1}/${training.endTime.getFullYear()} ${training.endTime.getHours()}:${training.endTime.getMinutes()}:${training.endTime.getSeconds()}`

        return training
    },
    getWorkloadObject(time) {
        let hour = Math.floor(time)
        let minute = time - hour
        
        let total = ((hour) + (minute))
        
        minute = Math.floor((time - hour) * 60)
        minute == 0 ? minute = '00' : ''
        
        return {
            'hour': hour,
            'minute': minute,
            'total': total,
        }
    }
}

export default model
export const getter = getters