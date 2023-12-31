import React, { FC } from 'react';
import * as _ from 'lodash';

interface DisplayResultsProps {
  t: number;
  p: number;
}

const DisplayResults: FC<DisplayResultsProps> = ({t, p}) => {
  if(!(t && p)) {
    return null;
  }

  return (
    <>
      <div className='card w-100 mb-3 py-2'>
        <span className='text-center fst-italic'>t = {t}</span>
      </div>
      <div className='card w-100 mb-3 py-2'>
        <span className='text-center fst-italic'>
          P(|t| {'>'} {Math.abs(t)}) = {p}
          <br />
          P = {_.round(p * 100, 1)}%
          </span>
      </div>
    </>
  );
}

export default DisplayResults;
