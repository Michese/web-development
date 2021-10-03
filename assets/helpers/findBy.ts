export default function findBy<T, K extends keyof T>(key: K, value: T[K]): (input: T) => boolean {
  return function (input) {
    return input[key] === value;
  };
}
