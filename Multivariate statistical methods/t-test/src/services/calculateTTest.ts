import { CalculatedData, CalculatedGroupData, TTestState } from "../components/Dashboard/reducer";
import _ from "lodash";
var ttest2 = require( '@stdlib/stats-ttest2' );

const getStandardDeviation = (array: number[]) => {
    var avg = _.sum(array) / array.length;
    return Math.sqrt(_.sum(_.map(array, (i) => Math.pow((i - avg), 2))) / array.length);
};

export const calculateGroupData = (state: TTestState): CalculatedData => {
    const { group1, group2 } = state.data;

    const result: CalculatedData = {
        group1: {
            mean: _.round(_.mean(group1.items), 3),
            standardDeviation: _.round(getStandardDeviation(group1.items), 3),
            count: group1.items.length,
        },
        group2: {
            mean: _.round(_.mean(group2.items), 3),
            standardDeviation: _.round(getStandardDeviation(group2.items), 3),
            count: group2.items.length,
        }
    };

    return result;
};

const getT = (state: TTestState) => {
    const { group1, group2 } = state.data;
    if(!(group1.items && group2.items)) {
        return 0;
    }

    const t = _.round((group1.mean - group2.mean)/(Math.sqrt((Math.pow(group1.standardDeviation, 2)/group1.count) + (Math.pow(group2.standardDeviation, 2)/group2.count))), 3);

    return t;
};

const getP = (state: TTestState) => {
    const { group1, group2, significanceLevel } = state.data;
    if(group1.items.length === 0 || group2.items.length === 0) {
        return 0;
    }

    const stat = ttest2(group1.items, group2.items, {alpha: significanceLevel});
    console.info(stat);

    return _.round(stat.pValue, 3);
};

export const getProbability = (state: TTestState): {t: number, p: number} => {
    return { t: getT(state), p: getP(state) };
}