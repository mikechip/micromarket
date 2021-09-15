export interface IResponseItemsList {
    count: number
    list: IItem[]
}

export interface IResponseItem {
    item: IItem
}

export interface IItem {
    id: number
    title: string
    desc: string
    price: number
    image_url: string
}
