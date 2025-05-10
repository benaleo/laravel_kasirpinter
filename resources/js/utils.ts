export function cn(...inputs: any[]) {
  return inputs.filter(Boolean).join(' ')
}

export function valueUpdater(updaterOrValue: any, value: any) {
  if (typeof updaterOrValue === 'function') {
    return updaterOrValue(value)
  }
  return updaterOrValue
}
