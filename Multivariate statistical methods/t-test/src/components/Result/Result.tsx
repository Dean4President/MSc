import React, { FC, useState } from 'react';
import { Button, Form } from 'react-bootstrap';
import SignificanceLevel from './SignificanceLevel/SignificanceLevel';
import DisplayResults from './DisplayResults/DisplayResults';

interface ResultProps {
  significanceLevel: number;
  t: number,
  p: number,
  setSignificaceLevel: (newValue: number) => void;
  calculate: () => void;
  resetAll: () => void;
}

const Result: FC<ResultProps> = ({significanceLevel, t, p, setSignificaceLevel, calculate, resetAll}) => {

  const refresh = (): void => {
    window.location.reload();
  }

  return (
    <div className='card bg-light w-100 h-100 p-3'>
      <SignificanceLevel significanceLevel={significanceLevel} setSignificaceLevel={setSignificaceLevel} />
      <DisplayResults t={t} p={p}/>
      <Button className='mt-auto' variant='danger' onClick={refresh}>Reset all</Button>
    </div>
  );
}

export default Result;
