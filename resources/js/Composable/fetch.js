export const useParentRouteName = (route) => {
    const segments = route.split(":");
    segments.pop();
    return segments.join(":");
};