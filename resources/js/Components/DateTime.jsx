import { format } from "date-fns";
import { ru } from "date-fns/locale";

export default function DateTime({ date }) {
    return date && (
        <>{format(date, 'd MMMM yyyy в H:ii', { locale: ru })}</>
    );
};
