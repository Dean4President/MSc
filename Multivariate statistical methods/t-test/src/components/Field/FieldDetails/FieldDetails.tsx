import React, { FC } from 'react';

interface FieldItemProps {
  mean: number,
  standardDeviation: number,
  count: number,
}

const FieldDetails: FC<FieldItemProps> = ({mean, standardDeviation, count}) => {
  return (
    <div className='d-flex flex-wrap justify-content-around'>
      <div>
        <span className='fw-bold'>Mean:</span> {mean}
      </div>
      <div>
        <span className='fw-bold'>Standard Deviation:</span> {standardDeviation}
      </div>
      <div>
        <span className='fw-bold'>Count:</span> {count}
      </div>
    </div>
  );
}

export default FieldDetails;
