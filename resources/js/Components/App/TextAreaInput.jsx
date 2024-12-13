import { forwardRef, useEffect, useImperativeHandle, useRef } from "react";

export default forwardRef(function TextAreaInput(
    { type = "text", className = "", isFocused = false, ...props },
    ref
) {
    const input = ref ? ref : useRef();

    useEffect(() => {
        if (isFocused) {
            input.current?.focus();
        }
    }, []);

    return (
        <textarea
            {...props}
            type={type}
            className={
                "rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 " +
                className
            }
            ref={input}
        ></textarea>
    );
});
