import { useEventBus } from "@/EventBus";
import { useEffect, useState } from "react";
import { v4 as uuidv4 } from "uuid";

export default function Toast({}) {
    const [toast, setToast] = useState([]);
    const { on } = useEventBus();

    useEffect(() => {
        on("toast.show", (message) => {
            const uuid = uuidv4();

            setToast((oldToasts) => [...oldToasts, { message, uuid }]);

            setTimeout(() => {
                setToast((oldToasts) =>
                    oldToasts.filter((toast) => toast.uuid !== uuid)
                );
            }, 5000);
        });
    }, [on]);

    return (
        <div className="toast min-w-[280px]">
            {toast.map((toast, index) => {
                return (
                    <div
                        key={toast.uuid}
                        className="alert alert-success py-3 px-4 text-gray-100 rounded-md min-w-280px"
                    >
                        <span>{toast.message}</span>
                    </div>
                );
            })}
        </div>
    );
}
