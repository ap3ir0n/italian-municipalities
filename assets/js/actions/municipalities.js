import axios from 'axios';

const ROOT_URL = '/api/';

export const FETCH_MUNICIPALITIES = 'FETCH_MUNICIPALITIES';
export const FETCH_MUNICIPALITY = 'FETCH_MUNICIPALITY';

export function fetchMunicipalities(page = 1, limit = 25) {
    const request = axios.get(`${ROOT_URL}municipalities?page=${page}&limit=${limit}`);

    return {
        type: FETCH_MUNICIPALITIES,
        payload: request
    };
}

export function fetchMunicipality(id) {
    const request = axios.get(`${ROOT_URL}municipalities/${id}`);

    return {
        type: FETCH_MUNICIPALITY,
        payload: request
    };
}