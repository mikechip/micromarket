import axios from "axios";
import {IResponseItem, IResponseItemsList} from "./entities"

interface IApiResponse {
    response: IResponseItemsList | IResponseItem | object | null
    request_time: number
    error: IApiError | null
}

interface IApiError {
    code: number
    text: string
    data: object | null
}

const Endpoint = process.env.REACT_APP_API_URL || 'http://localhost:8080/';

export async function query(method: string, body: object): Promise<IApiResponse> {
    try {
        const response = (await axios({
            method: 'post',
            url: Endpoint + method,
            data: body
        }))?.data;

        console.log('API ' + method + ': ', response);
        return response as IApiResponse;
    } catch (error) {
        console.warn('API ' + method + ': ', error);
        return error as IApiResponse;
    }
}
