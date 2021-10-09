export type TInput = {
  type: string;
  name: string;
  placeholder: string;
  patterns: { pattern: RegExp; alertText: string }[];
  defaultValue: string;
};
