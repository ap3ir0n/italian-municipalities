import axios from 'axios';

const ROOT_URL = '/api/';

export const FETCH_MUNICIPALITIES = 'FETCH_MUNICIPALITIES';
export const FETCH_MUNICIPALITY = 'FETCH_MUNICIPALITY';

export function fetchMunicipalities(url = null) {
    if (!url) {
        url = `${ROOT_URL}municipalities`;
    }
    const request = axios.get(url);

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