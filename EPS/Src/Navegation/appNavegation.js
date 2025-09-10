import { NavigationContainer } from "@react-navigation/native"; 
import AuthNav from "./authNav";

export default function AppNavegation() {
  return (
    <NavigationContainer>
      <AuthNav />
    </NavigationContainer>
  );
}