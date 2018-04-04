import axios from 'axios';

const ROOT_URL = '/api/';

export const FETCH_PROVINCES = 'FETCH_PROVINCES';

export function fetchProvinces(url = null) {
    if (!url) {
        url = `${ROOT_URL}provinces`;
    }
    const request = axios.get(url);

    return {
        type: FETCH_PROVINCES,
        payload: request
    };
}
