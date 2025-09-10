import { StatusBar } from "expo-status-bar";
import { createNativeStackNavigator } from "@react-navigation/native-stack";

// Navegación
import AppNavegation from "./Src/Navegation/appNavegation";

const Stack = createNativeStackNavigator();

export default function App() {
  return (
    <>
      <StatusBar style="auto" />
      <AppNavegation />
    </>
  );
}
