import service from "@/services/group"

const getters = {
    getGroups: () => service.getGroups(),
    getGroupsByEnterprise: (enterprise) => service.getGroupsByEnterprise(enterprise),
    getEnterprises: () => service.getEnterprises(),
}

export const getter = getters