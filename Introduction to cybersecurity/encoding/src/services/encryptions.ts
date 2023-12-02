import _ from "lodash";
import { GroupSubstitutionDecodeMap, GroupSubstitutionEncodeMap, playfairMatrix } from "../constants";

export const GroupSubstitutionEncode = (input: string): string => {
    let result: string = '';

    _.map(input, (i) => result += GroupSubstitutionEncodeMap.get(i));

    return result;
}
export const GroupSubstitutionDecode = (input: string): string => {
    let result: string = '';
    let tmp: string = '';
    
    _.map(input, (i) => {
        tmp += i;

        if(tmp.length === 3) {
            result += GroupSubstitutionDecodeMap.get(tmp);
            tmp = '';
        }
    });

    return result;
}

export const VernamEncode = (input: string, key: string): string => {
    if (input.length != key.length) {
        return 'WRONG KEY';
    }
    
    let result = '';
    
    for (let i = 0; i < input.length; i++) {
        const charCode = input.charCodeAt(i) ^ key.charCodeAt(i);
        result += String.fromCharCode(charCode + 32);
    }

    return result;    
}
export const VernamDecode = (input: string, key: string): string => {
    if (input.length != key.length) {
        return 'WRONG KEY';
    }
    
    let result = '';
    
    for (let i = 0; i < input.length; i++) {
        const charCode = (input.charCodeAt(i) - 32) ^ key.charCodeAt(i);
        result += String.fromCharCode(charCode);
    }

    return result; 
}

const findPosition = (letter: string): [number, number] => {
    for (let i = 0; i < 5; i++) {
      for (let j = 0; j < 5; j++) {
        if (playfairMatrix[i][j] === letter) {
          return [i, j];
        }
      }
    }
    throw new Error(`Letter ${letter} not found in the matrix.`);
  };

export const PlayfairEncode = (input: string): string => {
    try {
        input = input.toUpperCase().replaceAll('J', 'I');

        let result = '';

        for (let i = 0; i < input.length; i += 2) {
            let firstLetter = input[i];
            let secondLetter = input[i + 1] || 'Z';
        
            if (firstLetter === secondLetter) {
            secondLetter = 'X';
            i--;
            }
        
            const [row1, col1] = findPosition(firstLetter);
            const [row2, col2] = findPosition(secondLetter);
        
            let encryptedPair = '';
        
            if (row1 === row2) {
            encryptedPair += playfairMatrix[row1][(col1 + 1) % 5];
            encryptedPair += playfairMatrix[row2][(col2 + 1) % 5];
            } else if (col1 === col2) {
            encryptedPair += playfairMatrix[(row1 + 1) % 5][col1];
            encryptedPair += playfairMatrix[(row2 + 1) % 5][col2];
            } else {
            encryptedPair += playfairMatrix[row1][col2];
            encryptedPair += playfairMatrix[row2][col1];
            }
        
            result += encryptedPair;
        }
        
        return result;
    }
    catch(error) {
        return 'Incorrect word...'
    }
}
export const PlayfairDecode = (input: string): string => {
    try {
        input = input.toUpperCase();

        let result = '';

        for (let i = 0; i < input.length; i += 2) {
            const firstLetter = input[i];
            const secondLetter = input[i + 1];

            const [row1, col1] = findPosition(firstLetter);
            const [row2, col2] = findPosition(secondLetter);

            let decryptedPair = '';

            if (row1 === row2) {
            decryptedPair += playfairMatrix[row1][(col1 + 4) % 5];
            decryptedPair += playfairMatrix[row2][(col2 + 4) % 5];
            } else if (col1 === col2) {
            decryptedPair += playfairMatrix[(row1 + 4) % 5][col1];
            decryptedPair += playfairMatrix[(row2 + 4) % 5][col2];
            } else {
            decryptedPair += playfairMatrix[row1][col2];
            decryptedPair += playfairMatrix[row2][col1];
            }

            result += decryptedPair;
        }

        return result;
    }
    catch(error) {
        return 'Incorrect word...'
    }
}