import service from "@/services/group"

const getters = {
    getGroups: () => service.getGroups(),
    getGroupsByEnterprise: (enterprise) => service.getGroupsByEnterprise(enterprise),
    getOriginsByEnterprise: (enterprise) => service.getOriginsByEnterprise(enterprise),
    getEnterprises: () => service.getEnterprises(),
}

export const getter = getters