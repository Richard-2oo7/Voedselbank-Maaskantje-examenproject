export default function shortenString(str, maxLength = 20) {
    const myString = String(str).trim();
    return myString.length > 30 ? myString.slice(0, maxLength).trimEnd() + '...' : str;
}