export default function formatDate(myDate) {
    if(!myDate) return '-';
    const data = new Date(myDate).toLocaleDateString("nl", {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });

    const time = new Date(myDate).toLocaleTimeString("nl", {
        hour: 'numeric',
        minute: 'numeric',
    });

    return `${data} om ${time}`;
}