export function excludeKeys<T extends object, K extends keyof T>(
    obj: T,
    keys: K[],
): Omit<T, K> {
    return Object.fromEntries(
        Object.entries(obj).filter(([key]) => !keys.includes(key as K)),
    ) as Omit<T, K>;
}
