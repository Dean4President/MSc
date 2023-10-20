import React, { FC, useState } from 'react';
import { Group } from '../Dashboard/reducer';
import FieldItem from './FieldItem/FieldItem';
import FieldDetails from './FieldDetails/FieldDetails';
import { Button, Form } from 'react-bootstrap';
import './Field.css';

interface FieldProps {
  group: Group,
  addItem: (item: number) => void,
  deleteItem: (index: number) => void,
  resetGroup: () => void,
}

const Field: FC<FieldProps> = ({group, addItem, deleteItem, resetGroup}) =>{
  const [input, setInput] = useState<string>('');

  const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setInput(event.target.value);
  };

  const handleAddClick = () => {
    const item = parseFloat(input);
    if (item){
      addItem(item);
      setInput('');
    }
  };

  return (
    <div className='card bg-light w-100 h-100 p-4'>
      <div  className='d-flex flex-wrap justify-content-around mb-1'>
        {
          group.items.map((item: number, index: number) =>
          <FieldItem item={item} index={index} deleteItem={deleteItem}/>
        )}
      </div>
      <FieldDetails mean={group.mean} standardDeviation={group.standardDeviation} count={group.count} />
      
      <div className='d-flex flex-wrap justify-content-center flex-gap mt-4'>
        <div>
          <Form.Control className='form-control' type='number' value={input} onChange={handleInputChange} />
        </div>
        <div>
          <Button variant='dark' onClick={handleAddClick}>Add item</Button>
          <Button variant='danger' className='ms-2' onClick={resetGroup}>Reset group</Button>
        </div>
      </div>
    </div>
  );
}

export default Field;
