import React, { FC, useCallback, useEffect, useReducer, useState } from 'react';
import './Dashboard.css';
import tTestReducer, { TTestState, ReducerActionType, Group, CalculatedData } from './reducer';
import Field from '../Field/Field';
import Result from '../Result/Result';
import { calculateGroupData, getP, getT } from '../../services';

const Dashboard: FC = () => {
  const [reducerState, dispatch] = useReducer(tTestReducer, TTestState.initialValue);

  const recalculate = async (): Promise<void> => {
    await dispatch({type: ReducerActionType.CALCULATE_GROUP_DATA, item: calculateGroupData(reducerState)});
    await dispatch({type: ReducerActionType.CALCULATE_PROBABILITY, item: {t: getT(reducerState), p: getP(reducerState)}});
  };

  const addItemToGroup1 = async (item: number): Promise<void> => {
    await dispatch({type: ReducerActionType.ADD_GROUP_ONE, item});
    await recalculate();
  };
  const addItemToGroup2 = async (item: number): Promise<void> => {
    await dispatch({type: ReducerActionType.ADD_GROUP_TWO, item});
    await recalculate();
  };

  const deleteItemFromGroup1 = async (item: number): Promise<void> => {
    await dispatch({type: ReducerActionType.DELETE_ONE_GROUP_ONE, item});
    await recalculate();
  };
  const deleteItemFromGroup2 = async (item: number): Promise<void> => {
    await dispatch({type: ReducerActionType.DELETE_ONE_GROUP_TWO, item});
    await recalculate();
  };

  const resetGroup1 = async (): Promise<void> => {
    await dispatch({type: ReducerActionType.RESET_GROUP_ONE});
    await recalculate();
  };
  const resetGroup2 = async (): Promise<void> => {
    await dispatch({type: ReducerActionType.RESET_GROUP_TWO});
    await recalculate();
  };

  const setSignificaceLevel = async (item: number): Promise<void> => {
    await dispatch({type: ReducerActionType.SET_SIGNIFICANCE_LEVEL, item});
    await recalculate();
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
