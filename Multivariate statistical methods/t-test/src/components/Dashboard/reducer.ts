export enum ReducerActionType {
    ADD_GROUP_ONE = 'ADD_GROUP_ONE',
    DELETE_ONE_GROUP_ONE = 'DELETE_ONE_GROUP_ONE',
    RESET_GROUP_ONE = 'RESET_GROUP_ONE',
    ADD_GROUP_TWO = 'ADD_GROUP_TWO',
    DELETE_ONE_GROUP_TWO = 'DELETE_ONE_GROUP_TWO',
    RESET_GROUP_TWO = 'RESET_GROUP_TWO',
    SET_SIGNIFICANCE_LEVEL = 'SET_SIGNIFICANCE_LEVEL',
    CALCULATE_GROUP_DATA = 'CALCULATE_GROUP_DATA',
    CALCULATE_PROBABILITY = 'CALCULATE_PROBABILITY',
    RESET_ALL = 'RESET_ALL'
}

export type CalculatedGroupData = {
    mean: number,
    standardDeviation: number,
    count: number,
}

export type CalculatedData = {
    group1: CalculatedGroupData,
    group2: CalculatedGroupData,
}

export type ReducerAction = {
    type: ReducerActionType.ADD_GROUP_ONE | ReducerActionType.ADD_GROUP_TWO,
    item: number,
} | {
    type: ReducerActionType.DELETE_ONE_GROUP_ONE | ReducerActionType.DELETE_ONE_GROUP_TWO,
    item: number,
} | {
    type: ReducerActionType.RESET_GROUP_ONE | ReducerActionType.RESET_GROUP_TWO | ReducerActionType.RESET_ALL,
} | {
    type: ReducerActionType.SET_SIGNIFICANCE_LEVEL,
    item: number,
} | {
    type: ReducerActionType.CALCULATE_GROUP_DATA,
    item: CalculatedData,
} | {
    type: ReducerActionType.CALCULATE_PROBABILITY,
    item: {
        t: number,
        p: number,
    },
}

export interface Group {
    items: number[],
    mean: number,
    standardDeviation: number,
    count: number,
}

export interface TTestState {
    data: {
        group1: Group,
        group2: Group,
        significanceLevel: number,
        t: number,
        p: number,
    }
}

export namespace TTestState {
    export const initialValue: TTestState = {
        data: {
            group1: {
                items: [],
                mean: 0,
                standardDeviation: 0,
                count: 0,
            },
            group2: {
                items: [],
                mean: 0,
                standardDeviation: 0,
                count: 0,
            },
            significanceLevel: 0.05,
            t: 0,
            p: 0,
        }
    }
}

export default function tTestReducer(state: TTestState, action: ReducerAction): TTestState {
    switch (action.type) {
        case ReducerActionType.ADD_GROUP_ONE:
            state.data.group1.items.push(action.item);
            return state;

        case ReducerActionType.DELETE_ONE_GROUP_ONE: {
            state.data.group1.items.splice(action.item, 1);
            return state;
        };

        case ReducerActionType.RESET_GROUP_ONE:
            return {
                data: {
                    ...state.data,
                    group1: {
                        items: [],
                        mean: 0,
                        standardDeviation: 0,
                        count: 0,
                    },
                }
            };

        case ReducerActionType.ADD_GROUP_TWO:
            state.data.group2.items.push(action.item);
            return state;

        case ReducerActionType.DELETE_ONE_GROUP_TWO: {
            state.data.group2.items.splice(action.item, 1);
            return state;
        };

        case ReducerActionType.RESET_GROUP_TWO:
            return {
                data: {
                    ...state.data,
                    group2: {
                        items: [],
                        mean: 0,
                        standardDeviation: 0,
                        count: 0,
                    },
                }
            };

        case ReducerActionType.SET_SIGNIFICANCE_LEVEL:
            return {
                data: {
                    ...state.data,
                    significanceLevel: action.item,
                }
            };

        case ReducerActionType.CALCULATE_GROUP_DATA:
            return {
                data: {
                    ...state.data,
                    group1: {
                        ...state.data.group1,
                        mean: action.item.group1.mean,
                        standardDeviation: action.item.group1.standardDeviation,
                        count: action.item.group1.count,
                    },
                    group2: {
                        ...state.data.group2,
                        mean: action.item.group2.mean,
                        standardDeviation: action.item.group2.standardDeviation,
                        count: action.item.group2.count,
                    },
                }
            };

            case ReducerActionType.CALCULATE_PROBABILITY:
                return {
                    data: {
                        ...state.data,
                        t: action.item.t,
                        p: action.item.p,
                    }
                };

        case ReducerActionType.RESET_ALL:
            return TTestState.initialValue;
    }
}