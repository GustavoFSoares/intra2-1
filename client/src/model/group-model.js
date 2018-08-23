import service from "@/services/group"

const getters = {
    getEnterprises: () => service.getEnterprises(),
}

export const getter = getters