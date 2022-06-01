import { writable } from 'svelte/store';
import { checkStatus } from '../js/app';
export const store_STATUS = writable(checkStatus());