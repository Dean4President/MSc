import React, { FC } from 'react';
import './FieldItem.css';

interface FieldItemProps {
  item: number,
  index: number,
  deleteItem: (index: number) => void,
}

const FieldItem: FC<FieldItemProps> = ({item, index, deleteItem}) => {
  const tmp = () => {
    console.info('clicked...');
  }

  return (
    <div className='card card-item mb-2 px-2' onClick={() => deleteItem(index)}>
      <span className='fs-5 text-center'>{item}</span>
    </div>
  );
}

export default FieldItem;
