import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right", duration: 3000});

export const successNotification = (message) => {
  return toaster.success(message);
}

export const errorNotification = (message) => {
  return toaster.error(message);
}

export const warningNotification = (message) => {
  return toaster.warning(message);
}

export const infoNotification = (message) => {
  return toaster.info(message);
}