import {
    FormControl,
    FormErrorMessage,
    FormLabel,
    Input,
    RadioGroup,
} from "@chakra-ui/react";
import React from "react";
import { useField } from "react-final-form";

const Control = ({ name, ...rest }) => {
    const {
        meta: { error, touched },
    } = useField(name, { subscription: { touched: true, error: true } });
    return <FormControl {...rest} isInvalid={error && touched} />;
};

const Error = ({ name }) => {
    const {
        meta: { error, submitError, modifiedSinceLastSubmit },
    } = useField(name, {
        subscription: { submitError: true, modifiedSinceLastSubmit: true },
    });
    return (
        <div className="text-red-400 mt-2">
            {!modifiedSinceLastSubmit ? submitError : ""}
        </div>
    );
    // return <FormErrorMessage>{"Testing!"}</FormErrorMessage>;
};

export const AdaptedRadioGroup = ({ input, meta, label, children }) => (
    <FormControl isInvalid={meta.touched && meta.invalid} my={4}>
        <FormLabel htmlFor={input.name}>{label}</FormLabel>
        <RadioGroup {...input}>{children}</RadioGroup>
        <FormErrorMessage>{meta.error}</FormErrorMessage>
    </FormControl>
);
{
    /* <Field name="username">
            {({ input, meta }) => (
              <div>
                <label>Username</label>
                <input {...input} type="text" placeholder="Username" />
                {(meta.error || meta.submitError) && meta.touched && (
                  <span>{meta.error || meta.submitError}</span>
                )}
              </div>
            )}
          </Field> */
}
export const InputControl = ({ name, label, ...others }) => {
    const { input, meta } = useField(name);
    return (
        <Control name={name} my={4}>
            <FormLabel htmlFor={name}>{label}</FormLabel>
            <Input
                {...input}
                isInvalid={meta.submitError && meta.touched}
                id={name}
                placeholder={label}
                {...others}
            />
            <Error name={name} />
        </Control>
    );
};
