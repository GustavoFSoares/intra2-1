export default class Link {
    constructor(link = { active: true }) {
        this.id = link.id
        this.title = link.title
        this.url = link.url
        this.externalLink= link.externalLink
        this.icon= '/static/img/links/'+link.icon
        this.active= link.active ? true : false
        this.c_removed = link.c_removed ? true : false
        this.c_modified= link.c_modified
        this.c_created= link.c_created
    }
}
