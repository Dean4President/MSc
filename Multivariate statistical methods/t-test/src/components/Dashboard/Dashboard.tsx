import React, { FC, useCallback, useEffect, useReducer, useState } from 'react';
import './Dashboard.css';
import tTestReducer, { TTestState, ReducerActionType, Group, CalculatedData } from './reducer';
import Field from '../Field/Field';
import Result from '../Result/Result';
import { calculateGroupData, getProbability } from '../../services';

const Dashboard: FC = () => {
  const [reducerState, dispatch] = useReducer(tTestReducer, TTestState.initialValue);

  const recalculate = (): void => {
    dispatch({type: ReducerActionType.CALCULATE_GROUP_DATA, item: calculateGroupData(reducerState)});
    dispatch({type: ReducerActionType.CALCULATE_PROBABILITY, item: getProbability(reducerState)});
  };

  useEffect(recalculate, [reducerState]);

  const addItemToGroup1 = (item: number): void => {
    dispatch({type: ReducerActionType.ADD_GROUP_ONE, item});
  };
  const addItemToGroup2 = (item: number): void => {
    dispatch({type: ReducerActionType.ADD_GROUP_TWO, item});
  };

  const deleteItemFromGroup1 = (item: number): void => {
    dispatch({type: ReducerActionType.DELETE_ONE_GROUP_ONE, item});
  };
  const deleteItemFromGroup2 = (item: number): void => {
    dispatch({type: ReducerActionType.DELETE_ONE_GROUP_TWO, item});
  };

  const resetGroup1 = (): void => {
    dispatch({type: ReducerActionType.RESET_GROUP_ONE});
  };
  const resetGroup2 = (): void => {
    dispatch({type: ReducerActionType.RESET_GROUP_TWO});
  };

  const setSignificaceLevel = (item: number): void => {
    dispatch({type: ReducerActionType.SET_SIGNIFICANCE_LEVEL, item});
  }

  const resetAll = (): void => {
    dispatch({type: ReducerActionType.RESET_ALL});
  };

  return (
    <div className='container grid-container center'>
      <div className='group1'>
        <Field group={reducerState.data.group1}
          addItem={addItemToGroup1}
          deleteItem={deleteItemFromGroup1}
          resetGroup={resetGroup1}
        />
      </div>
      <div className='group2'>
        <Field
          group={reducerState.data.group2}
          addItem={addItemToGroup2}
          deleteItem={deleteItemFromGroup2}
          resetGroup={resetGroup2}
        />
      </div>
      <div className='result'>
        <Result significanceLevel={reducerState.data.significanceLevel}
          t={reducerState.data.t}
          p={reducerState.data.p}
          setSignificaceLevel={setSignificaceLevel}
          calculate={recalculate}
          resetAll={resetAll}
        />
      </div>
    </div>
  );
}

export default Dashboard;
