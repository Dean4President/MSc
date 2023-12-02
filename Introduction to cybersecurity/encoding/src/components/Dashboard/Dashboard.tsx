import React, { FC, useState } from 'react';
import './Dashboard.css';
import { Encryption, EncryptionDirection, EncryptionMethod } from '../../models';
import { Form } from 'react-bootstrap';
import { GroupSubstitutionDecode, GroupSubstitutionEncode, PlayfairDecode, PlayfairEncode, VernamDecode, VernamEncode } from '../../services';

const Dashboard: FC = () => {
	const defaultEncryption: Encryption = {direction: 'encode', method: 'group'};
	const [input, setInput] = useState<string>('TITOK');
	const [key, setKey] = useState<string>('KULCS');
	const [encryption, setEncryption] = useState<Encryption>(defaultEncryption);

	const setDirection = (direction: string) => {
		if (direction === "encode" || direction === "decode") {
			setEncryption({ ...encryption, direction});
		}
	}
	const setMethod = (method: string)  => {
		if (method === 'group' || method === 'vernam' || method === 'playfair') {
			setEncryption({ ...encryption, method});
		}
	}

	const encrypt = (input: string, key: string, encryption: Encryption ): string => {
		if(encryption.direction === 'encode') {
			switch (encryption.method) {
				case 'group': 
					return GroupSubstitutionEncode(input);
				case 'vernam': 
					return VernamEncode(input, key);
				case 'playfair': 
					return PlayfairEncode(input);
				default:
					return 'critical error';
			}
		}
		else if (encryption.direction === 'decode') {
			switch (encryption.method) {
				case 'group': 
					return GroupSubstitutionDecode(input);
				case 'vernam': 
					return VernamDecode(input, key);
				case 'playfair': 
					return PlayfairDecode(input);
				default:
					return 'critical error';
			}
		}
		else {
			return 'critical error';
		}
	}

	const output = encrypt(input, key, encryption);

	return (
		<div className='container center card bg-light w-100 p-5 shadow'>
		<Form>
			<Form.Group className="mb-3">
				<Form.Label>Message</Form.Label>
				<Form.Control type="text" value={input} onChange={(e) => setInput(e.currentTarget.value.toUpperCase())} />
			</Form.Group>
			<div key={`inline-radio`} className="mb-3">
			<Form.Check
				inline
				label="Encoding"
				name="direction"
				type="radio"
				value="encode"
				onChange={(e) => setDirection(e.currentTarget.value)}
				checked={encryption.direction === 'encode'}
			/>
			<Form.Check
				inline
				label="Decoding"
				name="direction"
				type="radio"
				value="decode"
				onChange={(e) => setDirection(e.currentTarget.value)}
				checked={encryption.direction === 'decode'}
			/>
			</div>
			<div key={`inline-radio`} className="mb-3">
			<Form.Check
				inline
				label="Group selection"
				name="method"
				type="radio"
				value="group"
				onChange={(e) => setMethod(e.currentTarget.value)}
				checked={encryption.method === 'group'}
			/>
			<Form.Check
				inline
				label="Vernam"
				name="method"
				type="radio"
				value="vernam"
				onChange={(e) => setMethod(e.currentTarget.value)}
				checked={encryption.method === 'vernam'}
			/>
			<Form.Check
				inline
				label="Playfair"
				name="method"
				type='radio'
				value="playfair"
				onChange={(e) => setMethod(e.currentTarget.value)}
				checked={encryption.method === 'playfair'}
			/>
			</div>
			{ encryption.method === 'vernam' && (
			<Form.Group className="mb-3">
				<Form.Label>Key</Form.Label>
				<Form.Control type="text" value={key} onChange={(e) => setKey(e.currentTarget.value)} />
			</Form.Group>
			)}
			<Form.Group className="mb-3">
			<Form.Label>{encryption.direction === 'encode' ? 'Encrypted' : 'Decrypted'} message</Form.Label>
			<Form.Control type="text" value={output} disabled/>
			</Form.Group>
		</Form>
		</div>
	);
}

export default Dashboard;
