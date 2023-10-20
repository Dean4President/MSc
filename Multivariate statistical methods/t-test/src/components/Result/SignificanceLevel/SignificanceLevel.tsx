import React, { FC } from 'react';
import { Form } from 'react-bootstrap';

interface SignificanceLevelProps {
  significanceLevel: number;
  setSignificaceLevel: (newValue: number) => void;
}

const SignificanceLevel: FC<SignificanceLevelProps> = ({significanceLevel, setSignificaceLevel}) => {

  const handleChange = (newValue: number): void => {
    setSignificaceLevel(newValue);
  };

  return (
    <Form>
        <div key='significanceLevel' className="d-flex flex-wrap justify-content-around mb-3">
          <span className='fw-bold me-2'>Significance level: </span>
          <Form.Check
            inline
            name={'significaceLevel'}
            type={'radio'}
            label={'0.01'}
            checked={significanceLevel === 0.01}
            onChange={() => handleChange(0.01)}
          />
          <Form.Check
            inline
            name={'significaceLevel'}
            type={'radio'}
            label={'0.05'}
            checked={significanceLevel === 0.05}
            onChange={() => handleChange(0.05)}
          />
          <Form.Check
            inline
            name={'significaceLevel'}
            type={'radio'}
            label={'0.10'}
            checked={significanceLevel === 0.1}
            onChange={() => handleChange(0.1)}
          />
        </div>
      </Form>
  );
}

export default SignificanceLevel;
