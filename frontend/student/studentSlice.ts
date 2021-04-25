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
    mode: "update" | "create";
}

// Define the initial state using that type
const initialState: StudentState = {
    selected: null,
    mode: "update",
};

export const studentSlice = createSlice({
    name: "student",
    // `createSlice` will infer the state type from the `initialState` argument
    initialState,
    reducers: {
        select: (
            state,
            action: PayloadAction<{
                student: IStudent;
                mode: StudentState["mode"];
            } | null>
        ) => {
            state.selected = action.payload.student;

            state.mode = action.payload.mode;
        },
        setMode: (state, action: PayloadAction<StudentState["mode"]>) => {
            state.mode = action.payload;
        },
    },
});

export const { select, setMode } = studentSlice.actions;

// Other code such as selectors can use the imported `RootState` type
export const selectStudent = (state: RootState) => state.student.selected;
export const selectMode = (state: RootState) => state.student.mode;

export default studentSlice.reducer;
