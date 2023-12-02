export interface Encryption {
    direction: EncryptionDirection;
    method: EncryptionMethod;
}

export type EncryptionDirection = 'encode' | 'decode';
export type EncryptionMethod = 'group' | 'vernam' | 'playfair';