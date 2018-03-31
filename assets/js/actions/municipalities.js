import axios from 'axios';

const ROOT_URL = 'http://localhost:8000/api/';

export const FETCH_MUNICIPALITIES = 'FETCH_MUNICIPALITIES';

export function fetchMunicipalities(page = 1, limit = 25) {
    const request = axios.get(`${ROOT_URL}municipalities?page=${page}&limit=${limit}`);

    return {
        type: FETCH_MUNICIPALITIES,
        payload: request
    };
}