import { createSlice, PayloadAction } from "@reduxjs/toolkit";
import { RootState } from "../app/store";

// Define a type for the slice state
export interface IStudent {
    id: number;
    idNumber: number;
    firstName: string;
    lastName: string;
    middleName: string;
    birthday: string;
    sex: string;
    slmisNumber: number;
}

interface StudentState {
    selected: null | IStudent;
}

// Define the initial state using that type
const initialState: StudentState = {
    selected: null,
};

export const studentSlice = createSlice({
    name: "student",
    // `createSlice` will infer the state type from the `initialState` argument
    initialState,
    reducers: {
        select: (state, action: PayloadAction<IStudent | null>) => {
            state.selected = action.payload;
        },
    },
});

export const { select } = studentSlice.actions;

// Other code such as selectors can use the imported `RootState` type
export const selectStudent = (state: RootState) => state.student.selected;

export default studentSlice.reducer;
